<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Tag;
use Session;
use Purifier;
use Image;
//use Storage;
use File;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // create a variable and store all the blog posts in it from the database
        $posts = Post::orderby('id', 'desc')->Paginate(10);
        //return a view and pass in the above variable
        return view('posts.index')->withPosts($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.create')->withCategories($categories)->withTags($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the data
        $this->validate($request, array(
            'title'          => 'required|max:255',
            'slug'           => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
            'category_id'    => 'required|integer',
            'body'           => 'required',
            'featured_image' => 'sometimes|images'
            
        ));
        // Store in thew database
        $post = new Post;

        $post->title = $request->title;
        $post->body  = Purifier::clean($request->body);
        $post->slug  = $request->slug;
        $post->category_id = $request->category_id;

        if($request->hasFile('featured_image'))
        {
            $image = $request->file('featured_image');
            $filename = time() . "." . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename); //file local path
            Image::make($image)->resize(800,400)->save($location);

            $post->image = $filename;
        }
        $post->save();
        
        // second parameter if true, overrides the existent associations
        $post->tags()->sync($request->tags, false);
        
        //"flash" exists for one page request
        //"Put" exists until the session is removed
        Session::flash('success', 'The blog post was successfully saved!');

        // redirect to another page
        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->withPost($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // find the post in the database
        $post = Post::find($id);
        $categories = Category::all();
        $cats=array();
        foreach($categories as $category)
        {
            $cats[$category->id] = $category->name;
        }
        $tags = Tag::all();
        $tags2 = array();
        foreach ($tags as $tag)
        {
            $tags2[$tag->id] = $tag->name;
        }

        //return the view and pass in the var we previously created
        return view('posts.edit')->withPost($post)->withCategories($cats)->withTags($tags2);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate the data before we use it
        $post = Post::find($id);

            $this->validate($request, array(
                'title'       => 'required|max:255',
                'slug'        => "required|alpha_dash|min:5|max:255|unique:posts,slug,$id",//check other than it self
                'category_id' => 'required|integer',
                'body'        => 'required',
                'feature'     => 'image'
            ));
        
        //Save the data to the database
        $post = Post::find($id);
        $post->title       = $request->title;
        $post->body        = Purifier::clean($request->body);
        $post->slug        = $request->slug;
        $post->category_id = $request->category_id;

        if ($request->hasFile('featured_image'))
        {            
            // add the new foto
            $image = $request->file('featured_image');
            $filename = time() . "." . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename); //file local path
            Image::make($image)->resize(800,400)->save($location);
            $oldFilename = $post->image;            
            // update database
            $post->image = $filename;
            // Delete the old foto
            //Storage::delete($oldFilename);
            //de um comentario ** assim nao tem de mexer na config Storage: 
            File::delete(public_path('images/' . $oldFilename));
        }

        $post->save();

        //if(isset($request->tags)){
        // second parameter if true, overrides the existent associations
        // with the new data (apaga as existentes e guarda as novas se tiver algo para guardar)
        $post->tags()->sync($request->tags);
        //}
       // else $post->tags()->sync(array());

        //set flash data with success message
        Session::flash('success', 'The blog post was successfully updated!');

        //redirect with flash data to posts.show
        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->tags()->detach();
        Storage::delete($post->image);
        $post->delete();
        //post::destroy($id);

        //set flash data with success message
        Session::flash('success', 'The blog post was successfully deleted!');
        
        return redirect()->route('posts.index');
    }
}
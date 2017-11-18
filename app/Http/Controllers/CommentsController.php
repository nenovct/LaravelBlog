<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Post;
use Session;

class CommentsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'store']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $post_id)
    {
        // Validate the data
        $this->validate($request, array(
            'name'    => 'required|max:255',
            'email'   => 'required|max:255|email',
            'comment' => 'required|min:5|max:255'            
        ));

        $post = Post::find($post_id);

        // Store in thew database
        $comment = new Comment();


        $comment->name     = $request->name;
        $comment->email    = $request->email;
        $comment->comment  = $request->comment;
        $comment->approved = true;
        $comment->post()->associate($post); // tb poderia ser assim: $comment->post_id = $post_id;

        $comment->save();

        Session::flash('success', 'The Comment was successfully sent!');

        // redirect to another page
        return redirect()->route('blog.single', $post->slug);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::find($id);
        return view('comments.edit')->withComment($comment);
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
        $comment = Comment::find($id);
        $this->validate($request, array('comment' => 'required'));

        $comment->comment = $request->comment;
        $comment->save();

        Session::flash('success', 'Commetn Updated');

        return redirect()->route('posts.show', $comment->post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirmDestroy($id)
    {
        $comment = Comment::find($id);
        return view('comments.confirmDestroy')->withComment($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $post_id)
    {
        $comment = Comment::find($id);
        if (!$comment){
            Session::flash('warning', 'The Comment does not exist or was already deleted!');
            return redirect()->route('posts.show', $post_id);
        }
          //$post_id = $comment->post->id;
            $comment->delete();
            Session::flash('success', 'The Comment was successfully deleted!');        
            return redirect()->route('posts.show', $post_id);
    }
}

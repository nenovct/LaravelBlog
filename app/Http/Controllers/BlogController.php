<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class BlogController extends Controller
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

    public function getIndex()
    {
        $posts = Post::orderby('id', 'desc')->Paginate(10);

        return view('blog.index')->withPosts($posts);
    }

    //
    Public function getSingle($slug)
    {
        //fetch from the database from slug
        $post = Post::where('slug','=', $slug)->first();
        //return the view and pass in the post object
        return view('blog.single')->withPost($post);
    }
}

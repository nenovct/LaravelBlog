<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Session;
use Mail;

class PagesController extends Controller
{
    public function getIndex()
    {
        # process data or params
        # talk to trhe model
        # receive from the model
        # compile or process data from the model if needed
        # pass that data to the correct view

        $posts = Post::orderBy('created_at', 'desc')->limit(4)->get(); //Post:: por defeito ja faz "select *"
        return view('pages.welcome')->withPosts($posts) ;
    }

    public function getAbout()
    {
        $first    = "Pedro";
        $last     = "Castro";
        $fullname = $first." ".$last;
        $email    = "pedromrios@gmail.com";

        $data=[];
        $data['email']=$email;
        $data['fullname']=$fullname;
        return view('pages.about')->withFullname($fullname)->withEmail($email)->withData($data);
    }

    public function getContact()
    {
        return view('pages.contact');
    }

        public function postContact(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'subject' => 'min:3',
            'message' => 'min:10'
            ]);

            /**laravel creates a variable for every key */
        $data = array(
            'email'       => $request->email,
            'subject'     => $request->subject,
            'bodyMessage' => $request->message
        );

        Mail::send('emails.contact', $data, function($message) use ($data){
            $message->from($data['email']);
            $message->to('pedromrios@gmail.com');
            $message->subject($data['subject']);
        });

        Session::flash('success', 'The message was successfully sent!');
        return redirect('/');
    }

}

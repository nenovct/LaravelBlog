@extends('main')

@section('title', '| Home')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="jumbotron">                    
                <h1 class="display-3">Welcome to my blog!</h1>
                <p class="lead">Thank you so much for visiting. This is my test website build with Laravel. Please read my popular post!</p>
                <p><a class="btn btn-primary btn-lg" href="#" role="button">Popular post</a></p>                        
            </div>
        </div> 
    </div>  <!--end of header row--> 

    <div class="row">
        <div class="col-md-8">
        @foreach($posts as $post)
                <div class="post">
                    <h3>{{ $post->title }}</h3>
                    <p>{{ substr(strip_tags($post->body), 0 , 300) }} {{ strlen(strip_tags($post->body)) > 300 ? "..." : "" }}</p>
                    <a class="btn btn-primary" href="{{ url('blog/'. $post->slug) }}" Role="button">Read More</a>
                </div>
                <hr>
            @endforeach
        </div>
        <div class="col-md-3 col-md-offset-1">
            <h2>Side bar</h2>
        </div> 
    </div><!--end of posts .row-->
@stop

@extends('main')

<?php $titleTag = htmlspecialchars($post->title); ?>
@section('title', "| $titleTag")

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <img src="{{ $post->image?asset('images/'. $post->image):"" }}" width"100%" height="400" alt="" />
            <h1>{{ $post->title }}</h1>
            <p>{!! $post->body !!}</p>
            <br>
            <p>Posted In: {{ $post->category->name }}</p>
           
            <div class="tags">
                @foreach ($post->tags as $tag)
                    <span class="label label-default">{{ $tag->name }}</span>
                @endforeach
            </div>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h3 class="comments-title">
                <span class="glyphicon glyphicon-comment"></span>
                {{ $post->comments()->count() }} Comments
            </h3>
            @foreach($post->comments as $comment)
                <div class="comment">
                    <div class="author-info">
                        <div class="author-avatar-container">
                            <img src="{{ 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($comment->email))) . '?s=50&d=monsterid' }}" class="author-avatar">
                            <!--<figure class="avatar-_outline"></figure>-->
                        </div>
                        <div class="author-name">
                            <h4>{{ $comment->name }}</h4>
                            <p class="author-time">{{ date('nS F Y - G:i', strtotime($comment->created_at)) }}</p>
                        </div>
                    </div>    
                    <div class="comment-content">
                        {{ $comment->comment }}
                    </div>                   
                </div>
            @endforeach
            <hr>
        </div>
    </div>
    <div class="row">        
        <div id="comment-form" class="col-md-8 col-md-offset-2">
            <h3 class="comments-form-title">
                <span class="glyphicon glyphicon-edit"></span> Leave a Comment
            </h3>
            {{ Form::open(['route' => ['comments.store', $post->id], 'method' => 'POST' ]) }}
                <div class="row">
                    <div class="col-md-6">
                        {{Form::label('name', 'Name:')}}
                        {{Form::text('name', null, ['class' => 'form-control'])}}
                    </div>
                    <div class="col-md-6">
                        {{Form::label('email', 'Email:')}}
                        {{Form::text('email', null, ['class' => 'form-control'])}}
                    </div>
                    <div class="col-md-12" style="margin-top:20px">
                        {{Form::label('comment', 'Comment:')}}
                        {{Form::textarea('comment', null, ['class' => 'form-control', 'rows' => '5'])}}

                        {{Form::submit('Add Comment', ['class' => 'btn btn-primary btn-block', 'style' => 'margin-top:20px;'])}}
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@stop
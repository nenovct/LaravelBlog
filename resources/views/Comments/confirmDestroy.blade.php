@extends('main')

@section('title', '| Delete Comment')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <h1>Permanentley delete this post?</h1>
        <p><strong>Name: </strong>{{ $comment->name }}</p>
        <p><strong>Email: </strong>{{ $comment->email }}</p>
        <p><strong>Comment: </strong>{{ $comment->comment }}</p>
            {!! Form::open(['route' => ['comments.destroy', $comment->id, $comment->post_id], 'method' => 'DELETE']) !!}
            {!! Form::submit('Delete Comment', ['class' => 'btn btn-block btn-danger']) !!}                       
            {!! Form::close() !!}
        </div>
    </div>
@stop
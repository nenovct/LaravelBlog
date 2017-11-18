@extends('main')

@section('title', '| View Post')

@section('content')

<div class="row">
    <div class="col-md-8">
    <img src="{{ $post->image?asset('images/'. $post->image):"" }}" width="100%" height="400" alt="" />
        <h2>{{ $post->title }}</h2>        
        <p class="lead">{!! $post->body !!}</p>
        <hr>
        <div class="tags">
            @foreach ($post->tags as $tag)
                <span class="label label-default">{{ $tag->name }}</span>
            @endforeach
        </div>
        <div class="backend-comments" style="margin-top:50px">
            <h3>Comments <small>{{ $post->comments()->count() }} total</small></h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Comment</th>
                        <th width="70px"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($post->comments as $comment)
                        <tr>
                            <td>{{ $comment->name }}</td>
                            <td>{{ $comment->email }}</td>
                            <td>{{ $comment->comment }}</td>
                            <td>
                            <div class="row">
                                <div class="col-xs-1">
                                    <a href="{{ route('comments.edit', $comment->id) }}" class="glyphicon glyphicon-pencil btn btn-xs btn-primary"></a>
                                </div>
                                <div class="col-xs-1">
                                    <!-- ********apagar sem confirmação********
                                    {!! Form::open(['route' => ['comments.destroy', $comment->id, $comment->post_id], 'method' => 'DELETE']) !!}                        
                                    <button class="glyphicon glyphicon-trash btn btn-xs btn-danger" type="submit"></button>
                                    {!! Form::close() !!}-->                                
                                    <a href="{{ route('comments.confirmDestroy', $comment->id) }}" class="glyphicon glyphicon-trash btn btn-xs btn-danger"></a>
                                </div>
                            </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-4">
        <div class="well">
            <dl class="">
                <label>Url Slug: </label> <p>
                                        <a href="{{ route('blog.single', $post->slug) }}">{{ route('blog.single', $post->slug) }}</a>
                                    </p>
            </dl>
            <dl class="">
                <label>Category: </label><p>{{ $post->category->name }}</p>
            </dl>
            <dl class="">
                <label>Created at: </label> <p>{{ date('M j, Y H:i', strtotime($post->created_at)) }}</p>
            </dl>
            <dl class="">
                <label>Last Updated: </label> <p>{{ date('M j, Y H:i', strtotime($post->updated_at)) }}</p>
            </dl>            
            <div class="row">
                <div class="col-sm-6">
                    {{ Html::linkRoute('posts.edit', 'Edit', array($post->id), array('class' => 'btn btn-primary btn-block')) }}
                   
                </div>
                <div class="col-sm-6">
                    {!! Form::open(['route' => ['posts.destroy', $post->id], 'method' => 'DELETE']) !!}                        
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    {{ Html::linkRoute('posts.index', '<< See All Posts', [], ['class' => 'btn btn-default btn-block btn-h1-spacing']) }}
                </div>
            </div>
        </div>
    </div>
</div>

@stop
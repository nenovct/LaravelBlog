@extends('main')

@section('title', '| Edit Tag')

@section('content')

    {{ Form::model($tag, ['route' => ['tags.update', $tag->id], 'method' => 'PUT']) }}

        {{Form::label('name', 'Title:')}}
        {{Form::text('name', null, ['class' => 'form-control'])}}

        {{Form::submit('Save Changes', ['class' => 'btn btn-primary', 'style' => 'margin-top:20px;'])}}
        {{ Html::linkRoute('tags.show', 'Cancel', array($tag->id), array('class' => 'btn btn-danger', 'style' => 'margin-top:20px;')) }}

    {{ Form::close() }}


@stop
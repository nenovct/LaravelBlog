@extends('main')

@section('title','| Create New Post')

@section('stylesheets')

{!! Html::style('css/parsley.css') !!}
{!! Html::style('css/select2.min.css') !!}
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
    tinymce.init({ 
        selector:'textarea',
        plugins: 'link code',
        //menu:{view:{title: 'Edit', items: 'cut, copy, paste'}}
        //toolbar: undo redo | cut copy paste
        menubar: false
    });
</script>

@stop

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Create New Post</h1>
            <hr>
            {!! Form::open(array('route' => 'posts.store', 'data-parsley-validate' => '', 'files' => 'true')) !!}
            
                {{ Form::label('title', 'Title:') }}
                {{ Form::text('title', null, array(
                    'class'     => 'form-control', 
                    'required'  => '', 
                    'maxlength' => "255"
                    )) }}

                {{ Form::label('slug', 'Slug:') }}
                {{ Form::text('slug', null, [
                    'class' => 'form-control', 
                    'required' => '', 
                    'minlenght' => '5',
                    'maxlenght' => '255'
                    ]) }}

                {{ Form::label('category_id', 'Category:') }}
                <select class="form-control" name="category_id">
                    @foreach($categories as $category)
                        <option value='{{ $category->id }}'>{{ $category->name }}</option>
                    @endforeach
                </select>

                {{ Form::label('tags', 'Tags:') }}
                <select class="select-multiple form-control" name="tags[]" multiple="multiple" style="width:100%">
                    @foreach($tags as $tag)
                        <option value='{{ $tag->id }}'>{{ $tag->name }}</option>
                    @endforeach
                </select>

                {{ Form::label('featured_image','Upload Featured Image') }}
                {{ Form::file('featured_image') }}

                {{ Form::label('body', 'Post Body:') }}
                {{ Form::textarea('body', null ,array(
                    'class'    => 'form-control'//, 
                    //'required' => ''
                    )) }}
                
                {{ Form::submit('Create Post',array(
                    'class' => 'btn btn-primary btn-lg btn-block',
                    'style' => 'margin-top: 20px'
                    )) }}

            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('scripts')

    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('js/select2.min.js') !!}

    <script type="text/javascript">
        $(document).ready(function() {
            $('.select-multiple').select2({
            });
        });
    </script>

@stop

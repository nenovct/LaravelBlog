@extends('main')

@section('title', '| Edit Blog Post')

@section('stylesheets')

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
    {!! Form::model($post, ['route' => ['posts.update', $post->id], 'method' => 'PUT', 'files' => 'true']) !!}
    <div class="col-md-8">
        {{ Form::label('title', 'Title:') }}
        {{ Form::text('title', null, ['class' => 'form-control']) }}

        {{ Form::label('category_id', 'Category:', ['class' => 'form-spacing-top']) }}
        {{ Form::select('category_id', $categories, null, ['class' => 'form-control']) }}

        {{ Form::label('tags', 'Tags:', ['class' => 'form-spacing-top']) }}
        <select class="select-multiple form-control" name="tags[]" multiple="multiple" style="width:100%">
            @foreach($tags as $tag_id => $tag_name)
                <option value='{{ $tag_id }}'>{{ $tag_name }}</option>
            @endforeach
        </select>

        {{ Form::label('slug', 'Slug:', ['class' => 'form-spacing-top']) }}
        {{ Form::text('slug', null, ['class' => 'form-control']) }}

        {{ Form::label('featured_image', 'Update Featured Image:', ['class' => 'form-spacing-top']) }}
        {{ Form::file('featured_image') }}

        {{ Form::label('body', 'Body:', ['class' => 'form-spacing-top']) }}
        {{ Form::textarea('body', null, ['class' => 'form-control']) }}       
    </div>
    <div class="col-md-4">
        <div class="well">
            <dl class="dl-horizontal">
                <dt>Created at: </dt> <dd>{{ date('M j, Y H:i', strtotime($post->created_at)) }}</dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>Last Updated: </dt> <dd>{{ date('M j, Y H:i', strtotime($post->updated_at)) }}</dd>
            </dl>
            <hr>
            <div class="row">
                <div class="col-sm-6">
                    {{ Html::linkRoute('posts.show', 'Cancel', array($post->id), array('class' => 'btn btn-danger btn-block')) }}
                </div>
                <div class="col-sm-6">
                {{ Form::submit('Save', ['class' => 'btn btn-success btn-block ']) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div><!--end of the form-->

@stop

@section('scripts')
    {!! Html::script('js/select2.min.js') !!}

        <script type="text/javascript">
            $(document).ready(function() {
                $('.select-multiple').select2();
                $('.select-multiple').select2().val({!! json_encode($post->tags()->allRelatedIds()) !!}).trigger('change');
            });
        </script>
@stop
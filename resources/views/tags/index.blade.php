@extends('main')

@section('title', '| All Tags')

@section('content')

    <div class="row">
        <div class="col-md-8">
            <h1>Tags</h1>
            <table class="table">
            <thead>
                <tr><th>#</th><th>Name</th></tr>
            </thead>
            <tbody>
                @foreach ($tags as $tag)
                <tr>
                    <th>{{ $tag->id }}</th><td><a href="{{ route('tags.show', $tag->id) }}">{{ $tag->name }}</a></td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div><!-- end of .col-md-8 -->

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">New tag</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('tags.store') }}">
                            {{ csrf_field() }}                            
                            <!-- Name -->
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-3 control-label">Name:</label>

                                <div class="col-md-7">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!-- Submit button -->
                            <div class="form-group">
                                <div class="col-md-7 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary btn-block">Create New Tag</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
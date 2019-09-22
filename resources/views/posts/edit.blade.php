<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
@extends('layouts.app')

{{-- Edit posts page for authorized users (post creator or admin) --}}
@section('content')

    <h1>Edit Post</h1>
    
    {!! Form::open(['action' => ['PostsController@update', $post->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
        </div>
        <div class="form-group">
            {{Form::label('body', 'Body')}}
            {{Form::textarea('body', $post->body, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body Text'])}}
        </div>
        <div class="form-group">
            {{Form::file('cover_image')}}
        </div>
        {{ Form::hidden('_method', 'PUT')}}
        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
    {!! Form::close() !!}

    <script>
        CKEDITOR.replace('article-ckeditor');
    </script>

@endsection
<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
@extends('layouts.app')

{{-- Edit comments page --}}
@section('content')

    <h1>Edit Comment</h1>
    
    {!! Form::open(['action' => ['CommentsController@update', $comment->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('body', 'Body')}}
            {{Form::textarea('body', $comment->body, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body Text'])}}
        </div>
        {{ Form::hidden('_method', 'PUT')}}
        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
    {!! Form::close() !!}

    <script>
        CKEDITOR.replace('article-ckeditor');
    </script>

@endsection
@extends('layouts.app')

<style>
    .display-comment .display-comment {
        margin-left: 40px
    }
</style>

{{-- Show specific post page --}}
@section('content')

    {{-- Go back button --}}
    <a href="/posts" class="btn btn-info">Go Back</a>
    <h1>{{$post->title}}</h1>
    <img style="height: 50%; width:50%" src="/storage/cover_images/{{$post->cover_image}}">
    <br><br>
    <div>
        {{-- !! parses html code --}}
        {!! $post->body !!}
    </div>
    <hr>

    {{-- Post details --}}
    <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
    <hr>

    {{-- Hides edit and delete buttons from non logged users --}}
    @auth
        @if (Auth::user()->id === $post->user_id || auth()->user()->role === 'admin')
        {{-- Edit button for posts --}}
            <a href="/posts/{{$post->id}}/edit" class="btn btn-info">Edit</a>
            <hr>
            {{-- Delete button for posts --}}
            {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right']) !!}
                {{ Form::hidden('_method', 'DELETE')}}
                {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
            {!! Form::close() !!}
        @endif
    @endauth

    {{-- Comment section --}}
    <br><br>
    <h4>Display Comments</h4>
    <br>
    @include('inc.comment_replies', ['comments' => $post->comments, 'post_id' => $post->id])
    <br><br>
    
    {{-- Add comment section --}}
    <h4>Add comment</h4>
    <form method="post" action="{{ route('comment.add') }}">
        @csrf
        <div class="form-group">
            <input type="text" name="comment_body" class="form-control" />
            <input type="hidden" name="post_id" value="{{ $post->id }}" />
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-warning" value="Add Comment" />
        </div>
    </form>

@endsection
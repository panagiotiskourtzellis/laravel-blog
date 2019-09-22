@foreach($comments as $comment)
<div class="display-comment">
    <strong>{{ $comment->user->name }}</strong>
    <br>
    {{-- !! parses html code --}}
    {!! $comment->body !!}
    <hr>
    {{-- Comment details --}}
    <small>Written on {{$comment->created_at}} by {{$comment->user->name}}</small>
    <hr>
    {{-- Reply to comments section --}}
    <a href="" id="reply"></a>
    <form method="post" action="{{ route('reply.add') }}">
        @csrf
        <div class="form-group">
            <input type="text" name="comment_body" class="form-control" />
            <input type="hidden" name="post_id" value="{{ $post_id }}" />
            <input type="hidden" name="comment_id" value="{{ $comment->id }}" />
        </div>
        
        <div class="form-group">
            <input type="submit" class="btn btn-warning" value="Reply" />
        </div>
    </form>
    <hr>
    {{-- Hides edit and delete buttons from non logged users --}}
    @auth
        @if (Auth::user()->id === $post->user_id || auth()->user()->role === 'admin')
            {{-- Edit button for comments --}}
            <td><a href="/comments/{{$comment->id}}/edit" class="btn btn-info">Edit</a></td>

            {{-- Delete button for comments --}}
            {!! Form::open(['action' => ['CommentsController@destroy', $comment->id], 'method' => 'POST', 'class' => 'float-right']) !!}
            {{ Form::hidden('_method', 'DELETE')}}
            {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
            {!! Form::close() !!}
            <br><hr>
        @endif
    @endauth
    {{-- Parameter passing --}}
    @include('inc.comment_replies', ['comments' => $comment->replies])
</div>
@endforeach
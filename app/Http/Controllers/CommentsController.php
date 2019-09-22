<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Post;
use App\User;
use DB;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Create new comment with relation to post
        $this->validate($request, [
            'comment_body' => 'required'
        ]);

        $comment = new Comment;
        $comment->body = $request->get('comment_body');
        $comment->user()->associate($request->user());
        $post = Post::find($request->get('post_id'));
        $post->comments()->save($comment);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Edit comment
        $comment = Comment::find($id);

        //check for correct user
        if(auth()->user()->id !== $comment->user_id) {
            return redirect('/posts')->with('error', 'Unathorized action');
        }

        return view('comments.edit')->with('comment', $comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        // Update after edit comment
        $comment = Comment::find($id);

        //check for correct user
        if(auth()->user()->id !== $comment->user_id && $role !== 'admin') {
            return redirect('/posts')->with('error', 'Unathorized action');
        }

        $comment->body = $request->get('body');
        $comment->save();

        return redirect('/posts/')->with('success', 'Comment Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete comment
        $comment = Comment::find($id);

        $role = auth()->user()->role;

        //check for correct user
        if(auth()->user()->id !== $comment->user_id && $role !== 'admin') {
            return redirect('/posts')->with('error', 'Unathorized action');
        }
        
        $comment->delete();

        return redirect('/posts')->with('success', 'Comment Deleted');
    }

    public function replyStore(Request $request)
    {
        // Create reply to comment
        $this->validate($request, [
            'comment_body' => 'required'
        ]);

        $reply = new Comment();
        $reply->body = $request->get('comment_body');
        $reply->user()->associate($request->user());
        $reply->parent_id = $request->get('comment_id');
        $post = Post::find($request->get('post_id'));

        $post->comments()->save($reply);

        return back();

    }
}
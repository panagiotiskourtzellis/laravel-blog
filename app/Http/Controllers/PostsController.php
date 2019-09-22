<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use DB;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$posts = Post::all(); //Eloquent way
        //$posts = Post::orderBy('title', 'desc')->get(); //Eloquent way
        //return Post::where('title', 'Post Two')->get(); //typical sql way
        //$posts = DB::select('SELECT * FROM posts'); // sql queries way
        
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create new post
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        // handle file upload
        if($request->hasFile('cover_image')) {
            // Get filename with the extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get just extension
            $extension = $request->file('cover_image')->guessClientExtension();
            // Filename to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            // Upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images/', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Edit post
        $post = Post::find($id);

        //check for correct user
        if(auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'Unathorized action');
        }

        return view('posts.edit')->with('post', $post);
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
        // Update after edit post
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        $post = Post::find($id);

        //check for correct user
        if(auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'Unathorized action');
        }

        // handle file upload
        if($request->hasFile('cover_image')) {
            // Get filename with the extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get just extension
            $extension = $request->file('cover_image')->guessClientExtension();
            // Filename to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            // Upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images/', $fileNameToStore);
        }
        
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if ($request->hasFile('cover_image')) {
            if ($post->cover_image != 'no_image.png') {
                Storage::delete('public/cover_images/'.$post->cover_image);
            }
            $post->cover_image = $fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete post
        $post = Post::find($id);

        //check for correct user
        if(auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'Unathorized action');
        }

        if ($post->cover_image != 'no_image.png') {
            Storage::delete('public/cover_images/'.$post->cover_image);
        }
        
        $post->delete();

        return redirect('/posts')->with('success', 'Post Deleted');
    }
}
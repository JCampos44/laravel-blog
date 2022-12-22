<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return response([
            'posts' => $posts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => Str::slug($request->title),
            'user_id' => auth()->user()->id
        ]);

        $path = $request->file('photo')->store('posts/' . $post->id);

        $post->update([
            'photo' => Storage::url($path)
        ]);

        return response([
            'post' => $post
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        return response([
            'post' => $post
        ]);
    }

    
    public function update(UpdatePostRequest $request)
    {
        $post = Post::where('id', $request->id)->firstOrFail();

        if (auth()->user()->cannot('isMyPost', $post)) {
            return response([
                'message' => 'No cuentas con los permisos para realizar esta accion'
            ], 403);
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'slug' => Str::slug($request->title)
        ]);

        if ($request->hasFile('photo')) {
            Storage::deleteDirectory('posts/' . $post->id);

            $path = $request->file('photo')->store('posts/' . $post->id);

            $post->update([
                'photo' => Storage::url($path)
            ]);
            
        }

        return response([
            'post' => $post
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $post = Post::where('id', $id)->firstOrFail();

        if (auth()->user()->cannot('isMyPost', $post)) {
            return response([
                'message' => 'No cuentas con los permisos para realizar esta accion'
            ], 403);
        }

        Storage::deleteDirectory('posts/' . $post->id);

        $post->delete();

        return response([
            'post' => $post
        ]);

    }
}

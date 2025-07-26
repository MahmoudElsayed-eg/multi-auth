<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = Arr::except($request->validated(), ['pic']);

        $post = Post::create($data);

        if ($request->hasFile('pic')) {
            $path = $request->file('pic')->store('uploads', 'public');
            $post->pic = $path;
            $post->save();
        }

        return response()->json(['message' => 'Post Created Successfully', 'post' => new PostResource($post)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = Arr::except($request->validated(), ['pic']);
        $post->update($data);
        if ($request->hasFile('pic')) {
            $path = $request->file('pic')->store('uploads', 'public');
            $post->pic = $path;
            $post->save();
        }

        return response()->json(['message' => 'Post Updated Successfully', 'post' => new PostResource($post)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,Post $post)
    {
        $user = $request->user();
        if ($user instanceof \App\Models\User && $post->user_id != $user->id) {
            return response()->json(['message'=>'unauthorized'],401);
        }
        if ($post->pic && Storage::disk('public')->exists($post->pic)) {
            Storage::disk('public')->delete($post->pic);
        }
        $post->delete();
        return response()->json(['message' => 'Post Deleted Succefully']);
    }
}

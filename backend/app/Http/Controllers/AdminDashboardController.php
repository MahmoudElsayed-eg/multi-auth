<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $filters = $request->only(['search','status','user_id']);
        $posts = Post::filters($filters)->paginate(20);
        $users = User::get(['id','name','email']);
        return response()->json([
            'message' => 'Admin Dashboard loaded successfully',
            'users' => $users,
            'posts' => new PostCollection($posts),
        ]);
    }
}

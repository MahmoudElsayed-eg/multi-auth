<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
        public function __invoke(Request $request)
    {
        $filters = $request->only(['search','status']);
        $posts = $request->user('user')->posts()->filters($filters)->paginate(20);
        return response()->json([
            'message' => 'User Dashboard loaded successfully',
            'posts' => new PostCollection($posts),
        ]);
    }
}

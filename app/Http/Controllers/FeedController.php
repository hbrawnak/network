<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Repository\FollowerRepository;
use App\Repository\PostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function get_feed(Request $request, FollowerRepository $followerRepository, PostRepository $postRepository)
    {
        $page      = $request->get('page', 1);
        $limit     = $request->get('limit', 10);
        $user      = Auth::user();
        $following = $followerRepository->following($user->uuid);
        $feed      = $postRepository->feed($following, $user->uuid, $page, $limit);

        return response()->json($feed);
    }
}

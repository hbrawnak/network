<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Repository\FollowerRepository;
use App\Repository\PostRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class FeedController extends Controller
{
    /**
     * Collecting feed based following result and feeds are storing in redis. And feeds from redis are
     * paginating in controller.
     *
     * @param Request $request
     * @param FollowerRepository $followerRepository
     * @param PostRepository $postRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_feed(Request $request, FollowerRepository $followerRepository, PostRepository $postRepository)
    {
        $page  = $request->get('page', 1);
        $limit = $request->get('limit', 10);

        $user      = auth()->user();
        $following = $followerRepository->following($user->uuid);
        $feed      = $postRepository->feed($following, $user->uuid);

        $collection = new Collection(Helper::formattedFeed($feed));

        $paginatedFeed = new LengthAwarePaginator(
            $collection->forPage($page, $limit),
            $collection->count(),
            $limit,
            $page
        );

        return response()->json([
            'error' => false,
            'message' => 'Feed result',
            'response' => $paginatedFeed
        ], 200);
    }
}

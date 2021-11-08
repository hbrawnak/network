<?php

namespace App\Http\Controllers;


use App\Jobs\ProcessFollower;
use App\Models\Follower;
use App\Repository\FollowerRepository;
use App\Repository\PageRepository;
use App\Repository\UserRepository;


class FollowerController extends Controller
{
    /**
     * Following new user is managing through queue. Queue is calling
     * to repository to create new following.
     *
     * @param string $personId
     * @param UserRepository $userRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function follow_person(string $personId, UserRepository $userRepository, FollowerRepository $followerRepository)
    {
        if (!$userRepository->exist($personId)) {
            return response()->json([
                'error' => true,
                'message' => 'Data validation error',
                'response' => 'Following ID doesn\'t exist'
            ], 401);
        }

        $user = auth()->user();

        if ($followerRepository->exist($user->uuid, $personId, Follower::SOURCE_TYPE_USER)) {
            return response()->json([
                'error' => true,
                'message' => 'Data validation error',
                'response' => 'You already followed the ID'
            ], 401);
        }

        $process = new ProcessFollower($user->uuid, $personId, Follower::SOURCE_TYPE_USER);
        $this->dispatch($process);

        return response()->json([
            'error' => false,
            'message' => 'Following success',
            'response' => []
        ], 200);
    }


    /**
     * Following new page is managing through queue. Queue is calling
     * to repository to create new following.
     *
     * @param string $pageId
     * @param PageRepository $pageRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function follow_page(string $pageId, PageRepository $pageRepository, FollowerRepository $followerRepository)
    {
        if (!$pageRepository->exist($pageId)) {
            return response()->json([
                'error' => true,
                'message' => 'Data validation error',
                'response' => 'Following ID doesn\'t exist'
            ], 401);
        }

        $user = auth()->user();

        if ($followerRepository->exist($user->uuid, $pageId, Follower::SOURCE_TYPE_PAGE)) {
            return response()->json([
                'error' => true,
                'message' => 'Data validation error',
                'response' => 'You already followed the ID'
            ], 401);
        }

        $process = new ProcessFollower($user->uuid, $pageId, Follower::SOURCE_TYPE_PAGE);
        $this->dispatch($process);

        return response()->json([
            'error' => false,
            'message' => 'Following success',
            'response' => []
        ], 200);
    }
}

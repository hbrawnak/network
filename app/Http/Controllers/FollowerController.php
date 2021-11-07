<?php

namespace App\Http\Controllers;


use App\Jobs\ProcessFollower;
use App\Models\Follower;
use App\Repository\PageRepository;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Auth;


class FollowerController extends Controller
{
    /**
     * @param string $personId
     * @param UserRepository $userRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function follow_person(string $personId, UserRepository $userRepository)
    {
        if (!$userRepository->exist($personId)) {
            return response()->json([
                'error' => true,
                'message' => 'Data validation error',
                'response' => 'Following ID doesn\'t exist'
            ], 401);
        }

        $user    = Auth::user();
        $process = new ProcessFollower($user->uuid, $personId, Follower::SOURCE_TYPE_USER);
        $this->dispatch($process);

        return response()->json([
            'error' => false,
            'message' => 'Following success',
            'response' => []
        ], 200);
    }


    /**
     * @param string $pageId
     * @param PageRepository $pageRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function follow_page(string $pageId, PageRepository $pageRepository)
    {
        if (!$pageRepository->exist($pageId)) {
            return response()->json([
                'error' => true,
                'message' => 'Data validation error',
                'response' => 'Following ID doesn\'t exist'
            ], 401);
        }

        $user    = Auth::user();
        $process = new ProcessFollower($user->uuid, $pageId, Follower::SOURCE_TYPE_PAGE);
        $this->dispatch($process);

        return response()->json([
            'error' => false,
            'message' => 'Following success',
            'response' => []
        ], 200);
    }
}

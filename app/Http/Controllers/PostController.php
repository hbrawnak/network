<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessPost;
use App\Models\Post;
use App\Repository\PageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * User post is creating though queue. Queue is basically calling the repository
     * under the hood.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user_post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => 'Data validation error',
                'response' => $validator->errors()
            ], 401);
        }


        $user    = auth()->user();
        $process = new ProcessPost(
            $user->uuid, Post::SOURCE_TYPE_USER, $request->input('text')
        );
        $this->dispatch($process);

        return response()->json([
            'error' => false,
            'message' => 'Post created',
            'response' => []
        ], 201);
    }

    /**
     * Page post is creating though queue. Queue is basically calling the repository
     * under the hood.
     *
     * @param Request $request
     * @param $pageId
     * @param PageRepository $pageRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function page_post(Request $request, $pageId, PageRepository $pageRepository)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => 'Data validation error',
                'response' => $validator->errors()
            ], 401);
        }

        if (!$pageRepository->exist($pageId)) {
            return response()->json([
                'error' => true,
                'message' => 'Data validation error',
                'response' => 'Following ID doesn\'t exist'
            ], 401);
        }

        $user = auth()->user();

        if (!$pageRepository->owner($pageId, $user->uuid)) {
            return response()->json([
                'error' => true,
                'message' => 'Data validation error',
                'response' => 'The page doesn\'t belong to you'
            ], 401);
        }

        $process = new ProcessPost(
            $pageId, Post::SOURCE_TYPE_PAGE, $request->input('text')
        );
        $this->dispatch($process);

        return response()->json([
            'error' => false,
            'message' => 'Post created',
            'response' => []
        ], 201);
    }
}

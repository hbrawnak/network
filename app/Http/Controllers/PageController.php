<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Repository\PageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    /**
     * After data validation it's calling to PageRepository to create new pages.
     *
     * @param Request $request
     * @param PageRepository $pageRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request, PageRepository $pageRepository)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:6|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => 'Data validation error',
                'response' => $validator->errors()
            ], 401);
        }

        try {
            $user = auth()->user();
            $page = $pageRepository->create($request, $user->uuid);

            return response()->json([
                'error' => false,
                'message' => 'created',
                'response' => Helper::pageFormattedResponse($page)
            ], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage(),
                'response' => []
            ], 401);
        }

    }
}

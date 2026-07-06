<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Services\SearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct(private readonly SearchService $searchService) {}

    public function index(Request $request): JsonResponse
    {
        $query = $request->get('q', '');

        if (strlen(trim($query)) < 2) {
            return response()->json(['data' => []]);
        }

        $results = $this->searchService->search($query, 10);

        return response()->json([
            'data' => PostResource::collection($results)->resolve(),
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Services\PostService;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __construct(private readonly PostService $postService) {}

    public function index(): Response
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'posts' => Post::count(),
                'categories' => Category::count(),
                'tags' => Tag::count(),
                'views' => Post::sum('views_count'),
            ],
            'mostViewed' => PostResource::collection(
                $this->postService->getMostViewed(5)
            )->resolve(),
        ]);
    }
}

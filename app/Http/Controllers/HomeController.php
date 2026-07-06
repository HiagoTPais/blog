<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\TagResource;
use App\Services\CategoryService;
use App\Services\PostService;
use App\Services\SeoService;
use App\Services\TagService;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __construct(
        private readonly PostService $postService,
        private readonly CategoryService $categoryService,
        private readonly TagService $tagService,
        private readonly SeoService $seoService,
    ) {}

    public function index(): Response
    {
        return Inertia::render('Blog/Home', [
            'posts' => PostResource::collection(
                $this->postService->getPublishedPaginated(config('blog.posts_per_page'))
            ),
            'recentPosts' => PostResource::collection(
                $this->postService->getRecent(config('blog.recent_posts_limit'))
            )->resolve(),
            'categories' => CategoryResource::collection(
                $this->categoryService->getAllWithCounts()
            )->resolve(),
            'popularTags' => TagResource::collection(
                $this->tagService->getPopular(config('blog.popular_tags_limit'))
            )->resolve(),
            'seo' => $this->seoService->forPage(
                config('blog.name'),
                'Blog de cybersegurança, hacking ético e tecnologia por '.config('blog.author'),
                'home'
            ),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\MarkdownService;
use App\Services\PostService;
use App\Services\SeoService;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function __construct(
        private readonly PostService $postService,
        private readonly MarkdownService $markdownService,
        private readonly SeoService $seoService,
    ) {}

    public function show(Post $post): Response
    {
        abort_unless($post->isPublished() || auth()->check(), 404);

        $this->postService->recordView(
            $post,
            request()->ip(),
            request()->userAgent()
        );

        $post->load(['category', 'tags', 'user']);

        return Inertia::render('Blog/Post', [
            'post' => (new PostResource($post))->resolve(),
            'tableOfContents' => $this->markdownService->extractHeadings($post->markdown),
            'relatedPosts' => PostResource::collection(
                $this->postService->getRelated($post, config('blog.related_posts_limit'))
            )->resolve(),
            'seo' => $this->seoService->forPost($post),
        ]);
    }
}

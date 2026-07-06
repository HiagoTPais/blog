<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Tag;
use App\Services\SeoService;
use App\Services\TagService;
use Inertia\Inertia;
use Inertia\Response;

class TagController extends Controller
{
    public function __construct(
        private readonly TagService $tagService,
        private readonly SeoService $seoService,
    ) {}

    public function show(Tag $tag): Response
    {
        return Inertia::render('Blog/Tags/Show', [
            'tag' => [
                'id' => $tag->id,
                'name' => $tag->name,
                'slug' => $tag->slug,
            ],
            'posts' => PostResource::collection(
                $this->tagService->getPostsByTag($tag, config('blog.posts_per_page'))
            ),
            'seo' => $this->seoService->forPage(
                "Tag: {$tag->name}",
                "Artigos marcados com {$tag->name}",
                'tags.show',
                ['tag' => $tag->slug]
            ),
        ]);
    }
}

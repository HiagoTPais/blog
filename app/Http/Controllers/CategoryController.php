<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\SeoService;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $categoryService,
        private readonly SeoService $seoService,
    ) {}

    public function index(): Response
    {
        return Inertia::render('Blog/Categories/Index', [
            'categories' => CategoryResource::collection(
                $this->categoryService->getAllWithCounts()
            ),
            'seo' => $this->seoService->forPage(
                'Categorias',
                'Explore artigos por categoria de cybersegurança e tecnologia.',
                'categories.index'
            ),
        ]);
    }

    public function show(Category $category): Response
    {
        return Inertia::render('Blog/Categories/Show', [
            'category' => (new CategoryResource($category))->resolve(),
            'posts' => PostResource::collection(
                $this->categoryService->getPostsByCategory($category, config('blog.posts_per_page'))
            ),
            'seo' => $this->seoService->forPage(
                $category->name,
                $category->description ?? "Artigos sobre {$category->name}",
                'categories.show',
                ['category' => $category->slug]
            ),
        ]);
    }
}

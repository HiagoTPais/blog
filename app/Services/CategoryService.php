<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function getAllWithCounts(): Collection
    {
        return Category::query()
            ->withCount(['posts as posts_count' => fn ($q) => $q->published()])
            ->orderBy('name')
            ->get();
    }

    public function getPostsByCategory(Category $category, int $perPage = 9)
    {
        return Post::query()
            ->published()
            ->where('category_id', $category->id)
            ->with(['category', 'tags', 'user'])
            ->latest('published_at')
            ->paginate($perPage);
    }
}

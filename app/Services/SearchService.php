<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class SearchService
{
    public function search(?string $query, int $perPage = 9): LengthAwarePaginator|Collection
    {
        if (empty(trim($query ?? ''))) {
            return collect();
        }

        $term = trim($query);

        return Post::query()
            ->published()
            ->with(['category', 'tags', 'user'])
            ->where(function ($q) use ($term) {
                $q->whereFullText(['title', 'excerpt', 'markdown'], $term)
                    ->orWhere('title', 'like', "%{$term}%")
                    ->orWhere('excerpt', 'like', "%{$term}%")
                    ->orWhereHas('category', fn ($cq) => $cq->where('name', 'like', "%{$term}%"))
                    ->orWhereHas('tags', fn ($tq) => $tq->where('name', 'like', "%{$term}%"));
            })
            ->latest('published_at')
            ->paginate($perPage);
    }
}

<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PostService
{
    public function getPublishedPaginated(int $perPage = 9): LengthAwarePaginator
    {
        return Post::query()
            ->published()
            ->with(['category', 'tags', 'user'])
            ->latest('published_at')
            ->paginate($perPage);
    }

    public function getRecent(int $limit = 5): Collection
    {
        return Post::query()
            ->published()
            ->with(['category', 'tags'])
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }

    public function getRelated(Post $post, int $limit = 3): Collection
    {
        $tagIds = $post->tags->pluck('id');

        return Post::query()
            ->published()
            ->where('id', '!=', $post->id)
            ->when($tagIds->isNotEmpty(), function ($query) use ($tagIds) {
                $query->whereHas('tags', fn ($q) => $q->whereIn('tags.id', $tagIds));
            }, function ($query) use ($post) {
                $query->where('category_id', $post->category_id);
            })
            ->with(['category', 'tags'])
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }

    public function getMostViewed(int $limit = 5): Collection
    {
        return Post::query()
            ->published()
            ->with(['category'])
            ->orderByDesc('views_count')
            ->limit($limit)
            ->get();
    }

    public function recordView(Post $post, string $ip, ?string $userAgent): void
    {
        $recentView = $post->views()
            ->where('ip_address', $ip)
            ->where('viewed_at', '>=', now()->subHours(24))
            ->exists();

        if ($recentView) {
            return;
        }

        $post->views()->create([
            'ip_address' => $ip,
            'user_agent' => $userAgent,
            'viewed_at' => now(),
        ]);

        $post->increment('views_count');
    }

    public function clearCache(): void
    {
        // Reserved for future cache invalidation if array-based caching is added.
    }
}

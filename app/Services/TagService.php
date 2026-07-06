<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

class TagService
{
    public function getPopular(int $limit = 15): Collection
    {
        return Tag::query()
            ->withCount(['posts as posts_count' => fn ($q) => $q->published()])
            ->having('posts_count', '>', 0)
            ->orderByDesc('posts_count')
            ->limit($limit)
            ->get();
    }

    public function getPostsByTag(Tag $tag, int $perPage = 9)
    {
        return Post::query()
            ->published()
            ->whereHas('tags', fn ($q) => $q->where('tags.id', $tag->id))
            ->with(['category', 'tags', 'user'])
            ->latest('published_at')
            ->paginate($perPage);
    }

    public function syncTags(Post $post, array $tagNames): void
    {
        $tagIds = collect($tagNames)
            ->filter()
            ->map(fn (string $name) => Tag::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($name)],
                ['name' => trim($name)]
            )->id);

        $post->tags()->sync($tagIds);
    }
}

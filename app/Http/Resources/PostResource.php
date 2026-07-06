<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'markdown' => $this->when(
                $request->routeIs('posts.show', 'admin.posts.*'),
                $this->markdown
            ),
            'cover_image' => $this->cover_image ? asset('storage/'.$this->cover_image) : null,
            'status' => $this->status,
            'published_at' => $this->published_at?->toISOString(),
            'published_at_formatted' => $this->published_at?->format('d M Y'),
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'views_count' => $this->views_count,
            'reading_time' => $this->reading_time,
            'category' => $this->when(
                $this->relationLoaded('category') && $this->category,
                fn () => (new CategoryResource($this->category))->resolve(),
            ),
            'tags' => $this->when(
                $this->relationLoaded('tags'),
                fn () => TagResource::collection($this->tags)->resolve(),
            ),
            'author' => $this->whenLoaded('user', fn () => [
                'name' => $this->user->name,
            ]),
        ];
    }
}

<?php

namespace App\Services;

use App\Models\Post;

class SeoService
{
    public function forPost(Post $post): array
    {
        $title = $post->meta_title ?: $post->title;
        $description = $post->meta_description ?: $post->excerpt;
        $url = route('posts.show', $post->slug);
        $image = $post->cover_image
            ? asset('storage/'.$post->cover_image)
            : asset('images/og-default.jpg');

        return [
            'title' => $title,
            'description' => $description,
            'canonical' => $url,
            'og' => [
                'title' => $title,
                'description' => $description,
                'url' => $url,
                'type' => 'article',
                'image' => $image,
            ],
            'twitter' => [
                'card' => 'summary_large_image',
                'title' => $title,
                'description' => $description,
                'image' => $image,
            ],
        ];
    }

    public function forPage(string $title, string $description, string $routeName, array $params = []): array
    {
        $url = route($routeName, $params);

        return [
            'title' => $title,
            'description' => $description,
            'canonical' => $url,
            'og' => [
                'title' => $title,
                'description' => $description,
                'url' => $url,
                'type' => 'website',
                'image' => asset('images/og-default.jpg'),
            ],
            'twitter' => [
                'card' => 'summary_large_image',
                'title' => $title,
                'description' => $description,
                'image' => asset('images/og-default.jpg'),
            ],
        ];
    }
}

<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
            'blog' => [
                'name' => config('blog.name'),
                'author' => config('blog.author'),
                'github' => config('blog.github'),
                'linkedin' => config('blog.linkedin'),
                'email' => config('blog.author_email'),
            ],
        ];
    }
}

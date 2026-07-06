<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\TagResource;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Services\PostService;
use App\Services\TagService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function __construct(
        private readonly TagService $tagService,
        private readonly PostService $postService,
    ) {}

    public function index(): Response
    {
        $posts = Post::query()
            ->with(['category', 'tags'])
            ->latest()
            ->paginate(15);

        return Inertia::render('Admin/Posts/Index', [
            'posts' => PostResource::collection($posts),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Posts/Form', [
            'post' => null,
            'categories' => CategoryResource::collection(Category::orderBy('name')->get())->resolve(),
            'allTags' => TagResource::collection(Tag::orderBy('name')->get())->resolve(),
        ]);
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        unset($data['tags']);
        $post = Post::create($data);

        if ($request->has('tags')) {
            $this->tagService->syncTags($post, $request->input('tags', []));
        }

        $this->postService->clearCache();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post criado com sucesso.');
    }

    public function edit(Post $post): Response
    {
        $post->load(['category', 'tags']);

        return Inertia::render('Admin/Posts/Form', [
            'post' => (new PostResource($post))->resolve(),
            'categories' => CategoryResource::collection(Category::orderBy('name')->get())->resolve(),
            'allTags' => TagResource::collection(Tag::orderBy('name')->get())->resolve(),
        ]);
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $data = $request->validated();

        if ($request->boolean('remove_cover') && $post->cover_image) {
            Storage::disk('public')->delete($post->cover_image);
            $data['cover_image'] = null;
        } elseif ($request->hasFile('cover_image')) {
            if ($post->cover_image) {
                Storage::disk('public')->delete($post->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        } else {
            unset($data['cover_image']);
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = $post->published_at ?? now();
        }

        unset($data['tags'], $data['remove_cover']);
        $post->update($data);

        if ($request->has('tags')) {
            $this->tagService->syncTags($post, $request->input('tags', []));
        }

        $this->postService->clearCache();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post atualizado com sucesso.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        if ($post->cover_image) {
            Storage::disk('public')->delete($post->cover_image);
        }

        $post->delete();
        $this->postService->clearCache();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post excluído com sucesso.');
    }
}

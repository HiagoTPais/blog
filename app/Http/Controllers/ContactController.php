<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Services\ContactService;
use App\Services\SeoService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function __construct(
        private readonly ContactService $contactService,
        private readonly SeoService $seoService,
    ) {}

    public function index(): Response
    {
        return Inertia::render('Blog/Contact', [
            'social' => [
                'github' => config('blog.github'),
                'linkedin' => config('blog.linkedin'),
                'email' => config('blog.author_email'),
            ],
            'seo' => $this->seoService->forPage(
                'Contato',
                'Entre em contato com Hiago Pais.',
                'contact'
            ),
        ]);
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        $this->contactService->send($request->validated());

        return back()->with('success', 'Mensagem enviada com sucesso!');
    }
}

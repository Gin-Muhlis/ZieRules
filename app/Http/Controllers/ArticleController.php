<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ArticleStoreRequest;
use App\Http\Requests\ArticleUpdateRequest;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Article::class);

        $search = $request->get('search', '');

        $articles = Article::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.articles.index', compact('articles', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Article::class);

        $users = User::pluck('name', 'id');

        return view('app.articles.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Article::class);

        $validated = $request->validated();
        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('public');
        }

        $article = Article::create($validated);

        return redirect()
            ->route('articles.edit', $article)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Article $article): View
    {
        $this->authorize('view', $article);

        return view('app.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Article $article): View
    {
        $this->authorize('update', $article);

        $users = User::pluck('name', 'id');

        return view('app.articles.edit', compact('article', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ArticleUpdateRequest $request,
        Article $article
    ): RedirectResponse {
        $this->authorize('update', $article);

        $validated = $request->validated();
        if ($request->hasFile('banner')) {
            if ($article->banner) {
                Storage::delete($article->banner);
            }

            $validated['banner'] = $request->file('banner')->store('public');
        }

        $article->update($validated);

        return redirect()
            ->route('articles.edit', $article)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Article $article
    ): RedirectResponse {
        $this->authorize('delete', $article);

        if ($article->banner) {
            Storage::delete($article->banner);
        }

        $article->delete();

        return redirect()
            ->route('articles.index')
            ->withSuccess(__('crud.common.removed'));
    }
}

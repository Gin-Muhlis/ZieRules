<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Teacher;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\QuoteStoreRequest;
use App\Http\Requests\QuoteUpdateRequest;
use Carbon\Carbon;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Quote::class);

        $search = $request->get('search', '');

        $quotes = Quote::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.quotes.index', compact('quotes', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Quote::class);

        $teachers = Teacher::pluck('name', 'id');

        return view('app.quotes.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuoteStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Quote::class);

        $validated = $request->validated();

        $now = Carbon::now()->format('Y-m-d');

        $validated['date'] = $now;

        $quote = Quote::create($validated);

        return redirect()
            ->route('quotes.edit', $quote)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Quote $quote): View
    {
        $this->authorize('view', $quote);

        return view('app.quotes.show', compact('quote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Quote $quote): View
    {
        $this->authorize('update', $quote);

        $teachers = Teacher::pluck('name', 'id');

        return view('app.quotes.edit', compact('quote', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        QuoteUpdateRequest $request,
        Quote $quote
    ): RedirectResponse {
        $this->authorize('update', $quote);

        $validated = $request->validated();

        $now = Carbon::now()->format('Y-m-d');

        $validated['date'] = $now;

        $quote->update($validated);

        return redirect()
            ->route('quotes.edit', $quote)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Quote $quote): RedirectResponse
    {
        $this->authorize('delete', $quote);

        $quote->delete();

        return redirect()
            ->route('quotes.index')
            ->withSuccess(__('crud.common.removed'));
    }
}

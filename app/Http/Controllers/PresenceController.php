<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PresenceStoreRequest;
use App\Http\Requests\PresenceUpdateRequest;

class PresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Presence::class);

        $presences = Presence::all();

        return view('app.presences.index', compact('presences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Presence::class);

        return view('app.presences.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PresenceStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Presence::class);

        $validated = $request->validated();
        $validated['name'] = strtolower($validated['name']);

        $presence = Presence::create($validated);

        return redirect()
            ->route('presences.edit', $presence)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Presence $presence): View
    {
        $this->authorize('view', $presence);

        return view('app.presences.show', compact('presence'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Presence $presence): View
    {
        $this->authorize('update', $presence);

        return view('app.presences.edit', compact('presence'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        PresenceUpdateRequest $request,
        Presence $presence
    ): RedirectResponse {
        $this->authorize('update', $presence);

        $validated = $request->validated();
        $validated['name'] = strtolower($validated['name']);

        $presence->update($validated);

        return redirect()
            ->route('presences.edit', $presence)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Presence $presence
    ): RedirectResponse {
        $this->authorize('delete', $presence);

        $presence->delete();

        return redirect()
            ->route('presences.index')
            ->withSuccess(__('crud.common.removed'));
    }
}

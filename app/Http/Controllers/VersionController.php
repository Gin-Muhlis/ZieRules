<?php

namespace App\Http\Controllers;

use App\Models\Version;
use App\Http\Requests\StoreVersionRequest;
use App\Http\Requests\UpdateVersionRequest;

class VersionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view-any', Version::class);
        
        $versions = Version::all();

        return view('app.versions.index', compact('versions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Version::class);

        return view('app.versions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVersionRequest $request)
    {
        
        $this->authorize('create', Version::class);

        $validated = $request->validated();
        
        $version = Version::create($validated);

        return redirect()
            ->route('versions.edit', $version)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Version $version)
    {
        $this->authorize('view', $version);

        return view('app.versions.show', compact('version'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Version $version)
    {
        $this->authorize('update', $version);

        return view('app.versions.edit', compact('version'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVersionRequest $request, Version $version)
    {
        $this->authorize('update', $version);

        $validated = $request->validated();

        $version->update($validated);

        return redirect()
            ->route('versions.edit', $version)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Version $version)
    {
        $this->authorize('delete', $version);

        $version->delete();

        return redirect()
            ->route('versions.index')
            ->withSuccess(__('crud.common.removed'));
    }
}

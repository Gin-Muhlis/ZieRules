<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Homeroom;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\ClassStudent;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\HomeroomStoreRequest;
use App\Http\Requests\HomeroomUpdateRequest;

class HomeroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Homeroom::class);

        $homerooms = Homeroom::all();

        return view('app.homerooms.index', compact('homerooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Homeroom::class);

        $teachers = Teacher::pluck('name', 'id');
        $classes = ClassStudent::pluck('name', 'id');

        return view('app.homerooms.create', compact('teachers', 'classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HomeroomStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Homeroom::class);

        $validated = $request->validated();

        $homeroom = Homeroom::create($validated);

        return redirect()
            ->route('homerooms.edit', $homeroom)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Homeroom $homeroom): View
    {
        $this->authorize('view', $homeroom);

        return view('app.homerooms.show', compact('homeroom'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Homeroom $homeroom): View
    {
        $this->authorize('update', $homeroom);

        $teachers = Teacher::pluck('name', 'id');
        $classes = ClassStudent::pluck('name', 'id');

        return view(
            'app.homerooms.edit',
            compact('homeroom', 'teachers', 'classes')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        HomeroomUpdateRequest $request,
        Homeroom $homeroom
    ): RedirectResponse {
        $this->authorize('update', $homeroom);

        $validated = $request->validated();

        $homeroom->update($validated);

        return redirect()
            ->route('homerooms.edit', $homeroom)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Homeroom $homeroom
    ): RedirectResponse {
        $this->authorize('delete', $homeroom);

        $homeroom->delete();

        return redirect()
            ->route('homerooms.index')
            ->withSuccess(__('crud.common.removed'));
    }
}

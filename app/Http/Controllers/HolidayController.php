<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\HolidayStoreRequest;
use App\Http\Requests\HolidayUpdateRequest;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Holiday::class);

        $search = $request->get('search', '');

        $holidays = Holiday::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.holidays.index', compact('holidays', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Holiday::class);

        return view('app.holidays.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HolidayStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Holiday::class);

        $validated = $request->validated();

        $holiday = Holiday::create($validated);

        return redirect()
            ->route('holidays.edit', $holiday)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Holiday $holiday): View
    {
        $this->authorize('view', $holiday);

        return view('app.holidays.show', compact('holiday'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Holiday $holiday): View
    {
        $this->authorize('update', $holiday);

        return view('app.holidays.edit', compact('holiday'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        HolidayUpdateRequest $request,
        Holiday $holiday
    ): RedirectResponse {
        $this->authorize('update', $holiday);

        $validated = $request->validated();

        $holiday->update($validated);

        return redirect()
            ->route('holidays.edit', $holiday)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Holiday $holiday
    ): RedirectResponse {
        $this->authorize('delete', $holiday);

        $holiday->delete();

        return redirect()
            ->route('holidays.index')
            ->withSuccess(__('crud.common.removed'));
    }
}

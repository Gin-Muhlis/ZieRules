<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Student;
use Illuminate\View\View;
use App\Models\HistoryScan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\HistoryScanStoreRequest;
use App\Http\Requests\HistoryScanUpdateRequest;

class HistoryScanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', HistoryScan::class);

        $search = $request->get('search', '');

        $historyScans = HistoryScan::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.history_scans.index',
            compact('historyScans', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', HistoryScan::class);

        $teachers = Teacher::pluck('name', 'id');
        $students = Student::pluck('name', 'id');

        return view(
            'app.history_scans.create',
            compact('teachers', 'students')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HistoryScanStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', HistoryScan::class);

        $validated = $request->validated();

        $historyScan = HistoryScan::create($validated);

        return redirect()
            ->route('history-scans.edit', $historyScan)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, HistoryScan $historyScan): View
    {
        $this->authorize('view', $historyScan);

        return view('app.history_scans.show', compact('historyScan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, HistoryScan $historyScan): View
    {
        $this->authorize('update', $historyScan);

        $teachers = Teacher::pluck('name', 'id');
        $students = Student::pluck('name', 'id');

        return view(
            'app.history_scans.edit',
            compact('historyScan', 'teachers', 'students')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        HistoryScanUpdateRequest $request,
        HistoryScan $historyScan
    ): RedirectResponse {
        $this->authorize('update', $historyScan);

        $validated = $request->validated();

        $historyScan->update($validated);

        return redirect()
            ->route('history-scans.edit', $historyScan)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        HistoryScan $historyScan
    ): RedirectResponse {
        $this->authorize('delete', $historyScan);

        $historyScan->delete();

        return redirect()
            ->route('history-scans.index')
            ->withSuccess(__('crud.common.removed'));
    }
}

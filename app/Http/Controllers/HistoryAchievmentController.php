<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\View\View;
use App\Models\Achievment;
use Illuminate\Http\Request;
use App\Models\HistoryAchievment;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\HistoryAchievmentStoreRequest;
use App\Http\Requests\HistoryAchievmentUpdateRequest;

class HistoryAchievmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', HistoryAchievment::class);


        $historyAchievments = HistoryAchievment::all();

        return view(
            'app.history_achievments.index',
            compact('historyAchievments')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', HistoryAchievment::class);

        $students = Student::pluck('name', 'id');
        $teachers = Teacher::pluck('name', 'id');
        $achievments = Achievment::pluck('name', 'id');

        return view(
            'app.history_achievments.create',
            compact('students', 'teachers', 'achievments')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        HistoryAchievmentStoreRequest $request
    ): RedirectResponse {
        $this->authorize('create', HistoryAchievment::class);

        $validated = $request->validated();

        $historyAchievment = HistoryAchievment::create($validated);

        return redirect()
            ->route('history-achievments.edit', $historyAchievment)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request $request,
        HistoryAchievment $historyAchievment
    ): View {
        $this->authorize('view', $historyAchievment);

        return view(
            'app.history_achievments.show',
            compact('historyAchievment')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        Request $request,
        HistoryAchievment $historyAchievment
    ): View {
        $this->authorize('update', $historyAchievment);

        $students = Student::pluck('name', 'id');
        $teachers = Teacher::pluck('name', 'id');
        $achievments = Achievment::pluck('name', 'id');

        return view(
            'app.history_achievments.edit',
            compact('historyAchievment', 'students', 'teachers', 'achievments')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        HistoryAchievmentUpdateRequest $request,
        HistoryAchievment $historyAchievment
    ): RedirectResponse {
        $this->authorize('update', $historyAchievment);

        $validated = $request->validated();

        $historyAchievment->update($validated);

        return redirect()
            ->route('history-achievments.edit', $historyAchievment)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        HistoryAchievment $historyAchievment
    ): RedirectResponse {
        $this->authorize('delete', $historyAchievment);

        $historyAchievment->delete();

        return redirect()
            ->route('history-achievments.index')
            ->withSuccess(__('crud.common.removed'));
    }
}

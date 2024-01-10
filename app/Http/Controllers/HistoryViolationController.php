<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\View\View;
use App\Models\Violation;
use Illuminate\Http\Request;
use App\Models\HistoryViolation;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\HistoryViolationStoreRequest;
use App\Http\Requests\HistoryViolationUpdateRequest;

class HistoryViolationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', HistoryViolation::class);

        $historyViolations = HistoryViolation::all();

        return view(
            'app.history_violations.index',
            compact('historyViolations')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', HistoryViolation::class);

        $students = Student::pluck('name', 'id');
        $teachers = Teacher::pluck('name', 'id');
        $violations = Violation::pluck('name', 'id');

        return view(
            'app.history_violations.create',
            compact('students', 'teachers', 'violations')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        HistoryViolationStoreRequest $request
    ): RedirectResponse {
        $this->authorize('create', HistoryViolation::class);

        $validated = $request->validated();

        $historyViolation = HistoryViolation::create($validated);

        return redirect()
            ->route('history-violations.edit', $historyViolation)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request $request,
        HistoryViolation $historyViolation
    ): View {
        $this->authorize('view', $historyViolation);

        return view('app.history_violations.show', compact('historyViolation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        Request $request,
        HistoryViolation $historyViolation
    ): View {
        $this->authorize('update', $historyViolation);

        $students = Student::pluck('name', 'id');
        $teachers = Teacher::pluck('name', 'id');
        $violations = Violation::pluck('name', 'id');

        return view(
            'app.history_violations.edit',
            compact('historyViolation', 'students', 'teachers', 'violations')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        HistoryViolationUpdateRequest $request,
        HistoryViolation $historyViolation
    ): RedirectResponse {
        $this->authorize('update', $historyViolation);

        $validated = $request->validated();

        $historyViolation->update($validated);

        return redirect()
            ->route('history-violations.edit', $historyViolation)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        HistoryViolation $historyViolation
    ): RedirectResponse {
        $this->authorize('delete', $historyViolation);

        $historyViolation->delete();

        return redirect()
            ->route('history-violations.index')
            ->withSuccess(__('crud.common.removed'));
    }
}

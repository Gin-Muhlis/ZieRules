<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\View\View;
use App\Models\Violation;
use Illuminate\Http\Request;
use App\Models\DataViolation;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\DataViolationStoreRequest;
use App\Http\Requests\DataViolationUpdateRequest;

class DataViolationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', DataViolation::class);

        $search = $request->get('search', '');

        $dataViolations = DataViolation::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.data_violations.index',
            compact('dataViolations', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', DataViolation::class);

        $violations = Violation::pluck('name', 'id');
        $students = Student::pluck('name', 'id');
        $teachers = Teacher::pluck('name', 'id');

        return view(
            'app.data_violations.create',
            compact('violations', 'students', 'teachers')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DataViolationStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', DataViolation::class);

        $validated = $request->validated();

        $dataViolation = DataViolation::create($validated);

        return redirect()
            ->route('data-violations.edit', $dataViolation)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, DataViolation $dataViolation): View
    {
        $this->authorize('view', $dataViolation);

        return view('app.data_violations.show', compact('dataViolation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, DataViolation $dataViolation): View
    {
        $this->authorize('update', $dataViolation);

        $violations = Violation::pluck('name', 'id');
        $students = Student::pluck('name', 'id');
        $teachers = Teacher::pluck('name', 'id');

        return view(
            'app.data_violations.edit',
            compact('dataViolation', 'violations', 'students', 'teachers')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        DataViolationUpdateRequest $request,
        DataViolation $dataViolation
    ): RedirectResponse {
        $this->authorize('update', $dataViolation);

        $validated = $request->validated();

        $dataViolation->update($validated);

        return redirect()
            ->route('data-violations.edit', $dataViolation)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        DataViolation $dataViolation
    ): RedirectResponse {
        $this->authorize('delete', $dataViolation);

        $dataViolation->delete();

        return redirect()
            ->route('data-violations.index')
            ->withSuccess(__('crud.common.removed'));
    }
}

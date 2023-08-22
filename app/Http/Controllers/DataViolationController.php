<?php

namespace App\Http\Controllers;

use App\Exports\ViolationDataImport;
use App\Exports\ViolationExport;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\View\View;
use App\Models\Violation;
use Illuminate\Http\Request;
use App\Models\DataViolation;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\DataViolationStoreRequest;
use App\Http\Requests\DataViolationUpdateRequest;
use Maatwebsite\Excel\Facades\Excel;

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

    public function report(Request $request)
    {
        $this->authorize('view-any', DataViolation::class);

        $search = $request->get('search', '');

        $students = Student::with('dataViolations')->search($search)->get();

        $reports = [];

        foreach ($students as $student) {
            $reports[] = [
                'student_id' => $student->id,
                'name' => $student->name,
                'violationsCount' => $student->dataViolations->count(),
                'totalPoint' => $this->generatePoint($student->dataVIolations)
            ];
        }

        return view(
            'app.data_violations.report',
            compact('reports', 'search')
        );
    }

    public function detailReport(Student $student) {
        $this->authorize('view-any', DataViolation::class);

        $dataViolations = DataViolation::with('violation')->whereStudentId($student->id)->latest()->get();

        $reports = [];
        $student_id = $student->id;

        foreach ($dataViolations as $data) {
            $reports[] = [
                'student' => $student->name,
                'date' => $data->date->toDateString(),
                'violation' => $data->violation->name,
                'point' => $data->violation->point
            ];
        }

        return view(
            'app.data_violations.detail',
            compact('reports', 'student_id')
        );
    }

    public function exportData(Request $request)
    {
        
        return Excel::download(new ViolationExport, 'data_pelangggaran.xlsx');
    }

    public function exportDetail(Student $student) {
        return Excel::download(new ViolationExport($student->id), 'data_pelangggaran.xlsx');
    }

    private function generatePoint($data)
    {
        $point = 0;
        foreach ($data as $dataViolation) {
            $point += $dataViolation->violation->point;
        }

        return $point;
    }
}

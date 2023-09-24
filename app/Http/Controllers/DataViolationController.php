<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Violation;
use Illuminate\View\View;
use App\Models\ClassStudent;
use Illuminate\Http\Request;
use App\Models\DataViolation;
use App\Exports\ViolationExport;
use App\Exports\ViolationDataImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use App\Exports\DetailViolationExport;
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

        $dataViolations = DataViolation::all();

        return view(
            'app.data_violations.index',
            compact('dataViolations')
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

        $students = Student::with('dataViolations')->whereClassId(1)->get();
        $classes = ClassStudent::pluck('name', 'id');
        $dataStudent = Student::with('dataViolations')->get();
        $firstClass = ClassStudent::first();
        
        $reports = $this->generateReport($students);
        $dataReport = $this->generateReport($dataStudent);

        return view(
            'app.data_violations.report',
            compact('reports', 'classes', 'dataReport', 'firstClass')
        );
    }

    public function detailReport(Student $student) {
        $this->authorize('view-any', DataViolation::class);

        $dataViolations = DataViolation::with('violation')->whereStudentId($student->id)->latest()->get();

        $reports = [];
        $student_id = $student->id;
        $student_name = $student->name;
        $total_point = 0;

        foreach ($dataViolations as $data) {
            $total_point += $data->violation->point; 
            $reports[] = [
                'student_id' => $student->id,
                'student' => $student->name,
                'class' => $student->class_id,
                'date' => $data->date->toDateString(),
                'violation' => $data->violation->name,
                'point' => $data->violation->point
            ];
        }

        return view(
            'app.data_violations.detail',
            compact('reports', 'student_id', 'student_name', 'total_point')
        );
    }

    public function exportData(Request $request)
    {
        $this->authorize('view-any', StudentAbsence::class);

        $class = $request->input("class_student") != 'all' || !is_null($request->input("class_student")) ? $request->input("class_student") : null;

        $dataClass = ClassStudent::findOrFail($class);

        return Excel::download(new ViolationExport($dataClass), "laporan_pelanggaran_$dataClass->code.xlsx");
    }

    public function exportDetail(Student $student) {
        return Excel::download(new DetailViolationExport($student->id), "laporan_pelanggaran_$student->name.xlsx");
    }

    public function generateReport($collection) {
        $result = [];
        foreach ($collection as $student) {
            $result[] = [
                'student_id' => $student->id,
                'class' => $student->class_id,
                'name' => $student->name,
                'violationsCount' => $student->dataViolations->count(),
                'totalPoint' => $this->generatePoint($student->dataVIolations)
            ];
        }

        return $result;
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

<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentAbsence;
use App\Models\Teacher;
use Illuminate\View\View;
use App\Models\Achievment;
use App\Models\ClassStudent;
use Illuminate\Http\Request;
use App\Models\DataAchievment;
use App\Exports\AchievmentExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataAchievmentExport;
use Illuminate\Http\RedirectResponse;
use App\Exports\DetailAchievmentExport;
use App\Http\Requests\DataAchievmentStoreRequest;
use App\Http\Requests\DataAchievmentUpdateRequest;

class DataAchievmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', DataAchievment::class);

        $dataAchievments = DataAchievment::all();

        return view(
            'app.data_achievments.index',
            compact('dataAchievments')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', DataAchievment::class);

        $achievments = Achievment::pluck('name', 'id');
        $students = Student::pluck('name', 'id');
        $teachers = Teacher::pluck('name', 'id');

        return view(
            'app.data_achievments.create',
            compact('achievments', 'students', 'teachers')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DataAchievmentStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', DataAchievment::class);

        $validated = $request->validated();

        $dataAchievment = DataAchievment::create($validated);

        return redirect()
            ->route('data-achievments.edit', $dataAchievment)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, DataAchievment $dataAchievment): View
    {
        $this->authorize('view', $dataAchievment);

        return view('app.data_achievments.show', compact('dataAchievment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, DataAchievment $dataAchievment): View
    {
        $this->authorize('update', $dataAchievment);

        $achievments = Achievment::pluck('name', 'id');
        $students = Student::pluck('name', 'id');
        $teachers = Teacher::pluck('name', 'id');

        return view(
            'app.data_achievments.edit',
            compact('dataAchievment', 'achievments', 'students', 'teachers')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        DataAchievmentUpdateRequest $request,
        DataAchievment $dataAchievment
    ): RedirectResponse {
        $this->authorize('update', $dataAchievment);

        $validated = $request->validated();

        $dataAchievment->update($validated);

        return redirect()
            ->route('data-achievments.edit', $dataAchievment)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        DataAchievment $dataAchievment
    ): RedirectResponse {
        $this->authorize('delete', $dataAchievment);

        $dataAchievment->delete();

        return redirect()
            ->route('data-achievments.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function report(Request $request)
    {
        $this->authorize('view-any', DataAchievment::class);

        $students = Student::with('dataAchievments')->whereClassId(1)->get();
        $classes = ClassStudent::pluck('name', 'id');
        $dataStudent = Student::with('dataAchievments')->get();
        $firstClass = ClassStudent::first();

        $reports = $this->generateReport($students);
        $dataReport = $this->generateReport($dataStudent);

        return view(
            'app.data_achievments.report',
            compact('reports', 'classes', 'dataReport', 'firstClass')
        );

    }

    public function detailReport(Student $student) {
        $this->authorize('view-any', DataAchievment::class);

        $dataAchievments = DataAchievment::with('achievment')->whereStudentId($student->id)->latest()->get();

        $reports = [];
        $student_id = $student->id;
        $student_name = $student->name;
        $total_point = 0;

        foreach ($dataAchievments as $data) {
            $total_point += $data->achievment->point;
            $reports[] = [
                'student' => $student->name,
                'date' => $data->date->toDateString(),
                'achievment' => $data->achievment->name,
                'point' => $data->achievment->point
            ];
        }

        return view(
            'app.data_achievments.detail',
            compact('reports', 'student_id', 'student_name', 'total_point')
        );
    }

    public function exportData(Request $request)
    {
        $this->authorize('view-any', StudentAbsence::class);

        $class = $request->input("class_student") != 'all' || !is_null($request->input("class_student")) ? $request->input("class_student") : null;

        $dataClass = ClassStudent::findOrFail($class);

        return Excel::download(new AchievmentExport($dataClass), "laporan_prestasi_$dataClass->code.xlsx");
    }

    public function exportDetail(Student $student) {
        return Excel::download(new DetailAchievmentExport($student->id), "laporan_prestasi_$student->name.xlsx");
    }

    private function generateReport($collection) {
        $result = [];
        foreach ($collection as $student) {
            $result[] = [
                'student_id' => $student->id,
                'class' => $student->class_id,
                'name' => $student->name,
                'achievmentsCount' => $student->dataAchievments->count(),
                'totalPoint' => $this->generatePoint($student->dataAchievments)
            ];
        }

        return $result;
    }

    private function generatePoint($data)
    {
        $point = 0;
        foreach ($data as $dataAchievment) {
            $point += $dataAchievment->achievment->point;
        }

        return $point;
    }
}

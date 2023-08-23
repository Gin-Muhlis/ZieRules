<?php

namespace App\Http\Controllers;

use App\Exports\AchievmentExport;
use App\Exports\DataAchievmentExport;
use App\Exports\DetailAchievmentExport;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\View\View;
use App\Models\Achievment;
use Illuminate\Http\Request;
use App\Models\DataAchievment;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\DataAchievmentStoreRequest;
use App\Http\Requests\DataAchievmentUpdateRequest;
use Maatwebsite\Excel\Facades\Excel;

class DataAchievmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', DataAchievment::class);

        $search = $request->get('search', '');

        $dataAchievments = DataAchievment::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.data_achievments.index',
            compact('dataAchievments', 'search')
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

        $search = $request->get('search', '');

        $students = Student::with('dataAchievments')->search($search)->get();

        $reports = [];

        foreach ($students as $student) {
            $reports[] = [
                'student_id' => $student->id,
                'name' => $student->name,
                'achievmentsCount' => $student->dataAchievments->count(),
                'totalPoint' => $this->generatePoint($student->dataAchievments)
            ];
        }

        return view(
            'app.data_achievments.report',
            compact('reports', 'search')
        );

    }

    public function detailReport(Student $student) {
        $this->authorize('view-any', DataAchievment::class);

        $dataAchievments = DataAchievment::with('achievment')->whereStudentId($student->id)->latest()->get();

        $reports = [];
        $student_id = $student->id;

        foreach ($dataAchievments as $data) {
            $reports[] = [
                'student' => $student->name,
                'date' => $data->date->toDateString(),
                'achievment' => $data->achievment->name,
                'point' => $data->achievment->point
            ];
        }

        return view(
            'app.data_achievments.detail',
            compact('reports', 'student_id')
        );
    }

    public function exportData(Request $request)
    {
        return Excel::download(new AchievmentExport, 'data_prestasi.xlsx');
    }

    public function exportDetail(Student $student) {
        return Excel::download(new DetailAchievmentExport($student->id), 'data_pelangggaran.xlsx');
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

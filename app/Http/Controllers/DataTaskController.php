<?php

namespace App\Http\Controllers;

use App\Exports\DetailTaskExport;
use App\Models\Task;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\DataTask;
use Illuminate\View\View;
use App\Exports\TaskExport;
use App\Models\ClassStudent;
use Illuminate\Http\Request;
use App\Exports\DataTaskExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\DataTaskStoreRequest;
use App\Http\Requests\DataTaskUpdateRequest;

class DataTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', DataTask::class);

        $search = $request->get('search', '');

        $dataTasks = DataTask::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.data_tasks.index', compact('dataTasks', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', DataTask::class);

        $tasks = Task::pluck('name', 'id');
        $students = Student::pluck('name', 'id');
        $teachers = Teacher::pluck('name', 'id');

        return view(
            'app.data_tasks.create',
            compact('tasks', 'students', 'teachers')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DataTaskStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', DataTask::class);

        $validated = $request->validated();

        $dataTask = DataTask::create($validated);

        return redirect()
            ->route('data-tasks.edit', $dataTask)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, DataTask $dataTask): View
    {
        $this->authorize('view', $dataTask);

        return view('app.data_tasks.show', compact('dataTask'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, DataTask $dataTask): View
    {
        $this->authorize('update', $dataTask);

        $tasks = Task::pluck('name', 'id');
        $students = Student::pluck('name', 'id');
        $teachers = Teacher::pluck('name', 'id');

        return view(
            'app.data_tasks.edit',
            compact('dataTask', 'tasks', 'students', 'teachers')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        DataTaskUpdateRequest $request,
        DataTask $dataTask
    ): RedirectResponse {
        $this->authorize('update', $dataTask);

        $validated = $request->validated();

        $dataTask->update($validated);

        return redirect()
            ->route('data-tasks.edit', $dataTask)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        DataTask $dataTask
    ): RedirectResponse {
        $this->authorize('delete', $dataTask);

        $dataTask->delete();

        return redirect()
            ->route('data-tasks.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function report(Request $request)
    {
        $this->authorize('view-any', DataTask::class);

        $students = Student::with('dataTasks')->get();
        $classes = ClassStudent::pluck('name', 'id');

        $reports = [];

        foreach ($students as $student) {
            $reports[] = [
                'student_id' => $student->id,
                'class' => $student->class_id,
                'className' => $student->class->name,
                'name' => $student->name,
                'tasksCount' => $student->dataTasks->count(),
            ];
        }

        return view(
            'app.data_tasks.report',
            compact('reports', 'classes')
        );

    }

    public function detailReport(Student $student) {
        $this->authorize('view-any', DataTask::class);

        $dataTasks = DataTask::with('task')->whereStudentId($student->id)->latest()->get();

        $reports = [];
        $student_id = $student->id;
        $student_name = $student->name;

        foreach ($dataTasks as $data) {
            $reports[] = [
                'student' => $student->name,
                'date' => $data->date->toDateString(),
                'task' => $data->task->name
            ];
        }

        return view(
            'app.data_tasks.detail',
            compact('reports', 'student_id', 'student_name')
        );
    }

    public function exportData(Request $request) {
        $this->authorize('view-any', StudentAbsence::class);

        $class = $request->input("class_student") != 'all' || !is_null($request->input("class_student")) ? $request->input("class_student") : null;

        if (!is_null($class) && $request->input("class_student") != 'all') {
            $dataClass = ClassStudent::findOrFail($class);

            return Excel::download(new TaskExport($class), "laporan_tugas_$dataClass->code.xlsx");
        }
        return Excel::download(new TaskExport(null), 'laporan_tugas.xlsx');
    }

    public function exportDetail(Student $student) {
        return Excel::download(new DetailTaskExport($student->id), "laporan_tugas_$student->name.xlsx");
    }

}
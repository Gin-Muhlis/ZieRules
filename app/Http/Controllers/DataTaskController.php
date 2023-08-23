<?php

namespace App\Http\Controllers;

use App\Exports\DataTaskExport;
use App\Exports\TaskExport;
use App\Models\Task;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\DataTask;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\DataTaskStoreRequest;
use App\Http\Requests\DataTaskUpdateRequest;
use Maatwebsite\Excel\Facades\Excel;

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

        $search = $request->get('search', '');

        $students = Student::with('dataTasks')->search($search)->get();

        $reports = [];

        foreach ($students as $student) {
            $reports[] = [
                'student_id' => $student->id,
                'name' => $student->name,
                'tasksCount' => $student->dataTasks->count(),
            ];
        }

        return view(
            'app.data_tasks.report',
            compact('reports', 'search')
        );

    }

    public function detailReport(Student $student) {
        $this->authorize('view-any', DataTask::class);

        $dataTasks = DataTask::with('task')->whereStudentId($student->id)->latest()->get();

        $reports = [];
        $student_id = $student->id;

        foreach ($dataTasks as $data) {
            $reports[] = [
                'student' => $student->name,
                'date' => $data->date->toDateString(),
                'task' => $data->task->name
            ];
        }

        return view(
            'app.data_tasks.detail',
            compact('reports', 'student_id')
        );
    }

    public function exportData() {
        return Excel::download(new TaskExport, 'data_pelangggaran.xlsx');
    }

}
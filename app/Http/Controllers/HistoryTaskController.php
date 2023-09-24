<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\View\View;
use App\Models\HistoryTask;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\HistoryTaskStoreRequest;
use App\Http\Requests\HistoryTaskUpdateRequest;

class HistoryTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', HistoryTask::class);


        $historyTasks = HistoryTask::all();

        return view(
            'app.history_tasks.index',
            compact('historyTasks')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', HistoryTask::class);

        $students = Student::pluck('name', 'id');
        $teachers = Teacher::pluck('name', 'id');
        $tasks = Task::pluck('name', 'id');

        return view(
            'app.history_tasks.create',
            compact('students', 'teachers', 'tasks')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HistoryTaskStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', HistoryTask::class);

        $validated = $request->validated();

        $historyTask = HistoryTask::create($validated);

        return redirect()
            ->route('history-tasks.edit', $historyTask)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, HistoryTask $historyTask): View
    {
        $this->authorize('view', $historyTask);

        return view('app.history_tasks.show', compact('historyTask'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, HistoryTask $historyTask): View
    {
        $this->authorize('update', $historyTask);

        $students = Student::pluck('name', 'id');
        $teachers = Teacher::pluck('name', 'id');
        $tasks = Task::pluck('name', 'id');

        return view(
            'app.history_tasks.edit',
            compact('historyTask', 'students', 'teachers', 'tasks')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        HistoryTaskUpdateRequest $request,
        HistoryTask $historyTask
    ): RedirectResponse {
        $this->authorize('update', $historyTask);

        $validated = $request->validated();

        $historyTask->update($validated);

        return redirect()
            ->route('history-tasks.edit', $historyTask)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        HistoryTask $historyTask
    ): RedirectResponse {
        $this->authorize('delete', $historyTask);

        $historyTask->delete();

        return redirect()
            ->route('history-tasks.index')
            ->withSuccess(__('crud.common.removed'));
    }
}

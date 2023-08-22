<?php

namespace App\Http\Controllers;

use App\Imports\TaskImport;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Task::class);

        $search = $request->get('search', '');

        $tasks = Task::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.tasks.index', compact('tasks', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Task::class);

        return view('app.tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Task::class);

        $validated = $request->validated();

        $task = Task::create($validated);

        return redirect()
            ->route('tasks.edit', $task)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Task $task): View
    {
        $this->authorize('view', $task);

        return view('app.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Task $task): View
    {
        $this->authorize('update', $task);

        return view('app.tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        TaskUpdateRequest $request,
        Task $task
    ): RedirectResponse {
        $this->authorize('update', $task);

        $validated = $request->validated();

        $task->update($validated);

        return redirect()
            ->route('tasks.edit', $task)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Task $task): RedirectResponse
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function import(Request $request) {
        $this->authorize('create', Task::class);

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,csv'
        ], [
            'file.mimes' => 'File harus ber ekstensi .xlsx atau .csv'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validate();

        Excel::import(new TaskImport, $validated['file']);

        return redirect()->back()->with('success', 'Import data berhasil');

    }
}

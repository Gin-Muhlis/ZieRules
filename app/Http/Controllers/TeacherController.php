<?php

namespace App\Http\Controllers;

use App\Imports\TeacherImport;
use App\Models\Teacher;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TeacherStoreRequest;
use App\Http\Requests\TeacherUpdateRequest;
use App\Models\ClassStudent;
use App\Models\Homeroom;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Teacher::class);

        $teachers = Teacher::all();

        return view('app.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Teacher::class);

        $classes = ClassStudent::pluck('name', 'id');

        return view('app.teachers.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeacherStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Teacher::class);

        $validated = $request->validated();

        $validated['password_show'] = $validated['password'];
        $validated['password'] = Hash::make($validated['password']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $class_id = false;

        if (isset($validated['class_id'])) {
            $class_id = $validated['class_id'];
            unset($validated['class_id']);
        }

        $teacher = Teacher::create($validated);
        $teacher->assignRole($validated['role']);

        if ($class_id) {
            Homeroom::create([
                'teacher_id' => $teacher->id,
                'class_id' => $class_id
            ]);
        }

        return redirect()
            ->route('teachers.edit', $teacher)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Teacher $teacher): View
    {
        $this->authorize('view', $teacher);

        return view('app.teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Teacher $teacher): View
    {
        $this->authorize('update', $teacher);

        $classes = ClassStudent::pluck('name', 'id');

        return view('app.teachers.edit', compact('teacher', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        TeacherUpdateRequest $request,
        Teacher $teacher
    ): RedirectResponse {
        $this->authorize('update', $teacher);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password_show'] = $validated['password'];
            $validated['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('image')) {
            if ($teacher->image) {
                Storage::delete($teacher->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $teacher->update($validated);
        $roleName = $teacher->getRoleNames()->first();

        if ($roleName !== $validated['role']) {
            $class_id = false;

            if (isset($validated['class_id'])) {
                $class_id = $validated['class_id'];
                unset($validated['class_id']);
            }

            if ($validated['role'] == 'wali-kelas') {
                Homeroom::create([
                    'teacher_id' => $teacher->id,
                    'class_id' => $class_id
                ]);
            } else if ($validated['role'] == 'guru-mapel') {
                $teacher->homeroom()->delete();
            }

            $teacher->removeRole($roleName);
            $teacher->assignRole($validated['role']);
        }

        return redirect()
            ->route('teachers.edit', $teacher)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Teacher $teacher
    ): RedirectResponse {
        $this->authorize('delete', $teacher);

        if ($teacher->image) {
            Storage::delete($teacher->image);
        }

        $teacher->delete();

        return redirect()
            ->route('teachers.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function import(Request $request)
    {
        $this->authorize('create', Teacher::class);

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,csv'
        ], [
            'file.mimes' => 'File harus ber ekstensi .xlsx atau .csv'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validate();

        Excel::import(new TeacherImport, $validated['file']);

        return redirect()->back()->with('success', 'Import data berhasil');

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\ClassStudent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Student::class);

        $search = $request->get('search', '');

        $students = Student::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.students.index', compact('students', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Student::class);

        $classes = ClassStudent::pluck('name', 'id');

        return view('app.students.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Student::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        // create user for student
        $userStudent = User::create([
            'email' => null,
            'nis' => $validated['nis'],
            'password' => bcrypt($validated['password'])
        ]);

        // assign role user to student
        $userStudent->assignRole('user');

        // create format data to students table
        $dataStudent = [
            'user_id'  => $userStudent->id,
            'name' => $validated['name'],
            'image' => $validated['image'],
            'gender' => $validated['gender'],
            'password_show' => $validated['password'],
            'class_id' => $validated['class_id']
        ];

        $student = Student::create($dataStudent);

        return redirect()
            ->route('students.edit', $student)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Student $student): View
    {
        $this->authorize('view', $student);

        return view('app.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Student $student): View
    {
        $this->authorize('update', $student);

        $classes = ClassStudent::pluck('name', 'id');
        $users = User::pluck('email', 'id');

        return view(
            'app.students.edit',
            compact('student', 'classes', 'users')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        StudentUpdateRequest $request,
        Student $student
    ): RedirectResponse {
        $this->authorize('update', $student);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            if ($student->image) {
                Storage::delete($student->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $userStudent = User::findOrFail($student->id);

        $dataStudent = [
            'user_id'  => $userStudent->id,
            'name' => $validated['name'],
            'image' => $validated['image'],
            'gender' => $validated['gender'],
            'password_show' => $validated['password'],
            'class_id' => $validated['class_id']
        ];


        $student->update($dataStudent);

        return redirect()
            ->route('students.edit', $student)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Student $student
    ): RedirectResponse {
        $this->authorize('delete', $student);

        if ($student->image) {
            Storage::delete($student->image);
        }

        $student->delete();

        return redirect()
            ->route('students.index')
            ->withSuccess(__('crud.common.removed'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Exports\StudentAbsenceExport;
use App\Models\Student;
use App\Models\Presence;
use Illuminate\View\View;
use App\Models\ClassStudent;
use Illuminate\Http\Request;
use App\Models\StudentAbsence;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StudentAbsenceStoreRequest;
use App\Http\Requests\StudentAbsenceUpdateRequest;

class StudentAbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', StudentAbsence::class);

        $search = $request->get('search', '');

        $studentAbsences = StudentAbsence::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.student_absences.index',
            compact('studentAbsences', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', StudentAbsence::class);

        $students = Student::pluck('name', 'id');
        $presences = Presence::pluck('name', 'id');

        return view(
            'app.student_absences.create',
            compact('students', 'presences')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentAbsenceStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', StudentAbsence::class);

        $validated = $request->validated();

        $studentAbsence = StudentAbsence::create($validated);

        return redirect()
            ->route('student-absences.edit', $studentAbsence)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, StudentAbsence $studentAbsence): View
    {
        $this->authorize('view', $studentAbsence);

        return view('app.student_absences.show', compact('studentAbsence'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, StudentAbsence $studentAbsence): View
    {
        $this->authorize('update', $studentAbsence);

        $students = Student::pluck('name', 'id');
        $presences = Presence::pluck('name', 'id');

        return view(
            'app.student_absences.edit',
            compact('studentAbsence', 'students', 'presences')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        StudentAbsenceUpdateRequest $request,
        StudentAbsence $studentAbsence
    ): RedirectResponse {
        $this->authorize('update', $studentAbsence);

        $validated = $request->validated();

        $studentAbsence->update($validated);

        return redirect()
            ->route('student-absences.edit', $studentAbsence)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        StudentAbsence $studentAbsence
    ): RedirectResponse {
        $this->authorize('delete', $studentAbsence);

        $studentAbsence->delete();

        return redirect()
            ->route('student-absences.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function report(Request $request)
    {
        $this->authorize('view-any', StudentAbsence::class);

        $students = Student::with('studentAbsences')->get();
        $classes = ClassStudent::pluck('name', 'id');
        $reports = [];

        foreach ($students as $student) {
            $reports[] = [
                'student_id' => $student->id,
                'name' => $student->name,
                'class' => $student->class->id,
                'className' => $student->class->name,
                'presences' => $student->studentAbsences()->where('presence_id', 1)->get()->count(),
                'permissions' => $student->studentAbsences()->where('presence_id', 2)->get()->count(),
                'sicks' => $student->studentAbsences()->where('presence_id', 3)->get()->count(),
                'withoutExplanations' => $student->studentAbsences()->where('presence_id', 4)->get()->count(),
            ];
        }


        return view(
            'app.student_absences.report',
            compact('reports', 'classes')
        );
    }

    public function exportData(Request $request)
    {
        $this->authorize('view-any', StudentAbsence::class);

        $class = $request->input("class_student") ?? null;

        if (!is_null($class)) {
            return Excel::download(new StudentAbsenceExport($class), 'data_kehadiran.xlsx');
        }

        return Excel::download(new StudentAbsenceExport(null), 'data_kehadiran.xlsx');
    }
}

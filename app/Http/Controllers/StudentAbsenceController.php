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

        $studentAbsences = StudentAbsence::all();

        return view(
            'app.student_absences.index',
            compact('studentAbsences')
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

        $students = Student::with('studentAbsences')->whereClassId(1)->get();
        $classes = ClassStudent::pluck('name', 'id');
        $dataStudent = Student::with('studentAbsences')->get();
        $firstClass = ClassStudent::first();

        $reports = $this->generateReport($students);
        $dataReport = $this->generateReport($dataStudent);

        return view(
            'app.student_absences.report',
            compact('reports', 'classes', 'dataReport', 'firstClass')
        );
    }

    public function exportData(Request $request)
    {
        $this->authorize('view-any', StudentAbsence::class);

        $class = $request->input("class_student") ?? null;

        $dataClass = ClassStudent::findOrFail($class);
        return Excel::download(new StudentAbsenceExport($dataClass), "laporan_kehadiran_$dataClass->code.xlsx");
    }

    private function generateReport($collection)
    {
        $result = [];

        foreach ($collection as $student) {
            $presences = 0;
            $permissions = 0;
            $sicks = 0;
            $withoutExplanations = 0;
            $absences = StudentAbsence::whereStudentId($student->id)->get();
            foreach ($absences as $absence) {
                $presences = strtolower($absence->presence->name) == 'hadir' ? $presences + 1 : $presences;
                $permissions = strtolower($absence->presence->name) == 'izin' ? $permissions + 1 : $permissions;
                $sicks = strtolower($absence->presence->name) == 'sakit' ? $sicks + 1 : $sicks;
                $withoutExplanations = strtolower($absence->presence->name) == 'tanpa keterangan' ? $withoutExplanations + 1 : $withoutExplanations;
            }
            $result[] = [
                'student_id' => $student->id,
                'name' => $student->name,
                'class' => $student->class->id,
                'presences' => $presences,
                'permissions' => $permissions,
                'sicks' => $sicks,
                'withoutExplanations' => $withoutExplanations,
            ];
        }
        return $result;
    }
}

<?php

namespace App\Exports;

use App\Models\Student;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StudentAbsenceExport implements FromView
{

    private $class;

    public function __construct($classFilter) {
        $this->class = $classFilter;
    }
    public function view(): View
    {

        $students = null;

        $students = Student::with('studentAbsences')->get();
        
        if (!is_null($this->class)) {
            $students = Student::with('studentAbsences')->whereClassId($this->class)->get();
        }
        $reports = [];

        foreach ($students as $student) {
            $reports[] = [
                'name' => $student->name,
                'className' => $student->class->name,
                'presences' => $student->studentAbsences()->where('presence_id', 1)->get()->count(),
                'permissions' => $student->studentAbsences()->where('presence_id', 2)->get()->count(),
                'sicks' => $student->studentAbsences()->where('presence_id', 3)->get()->count(),
                'withoutExplanations' => $student->studentAbsences()->where('presence_id', 4)->get()->count(),
            ];
        }

        return view(
            'app.student_absences.export',
            compact('reports')
        );
    }
}

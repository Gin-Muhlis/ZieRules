<?php

namespace App\Exports;

use App\Models\Student;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class AchievmentExport implements FromView
{
    private $class;

    public function __construct($classFilter) {
        $this->class = $classFilter;
    }
    public function view(): View
    {
       
        $students = Student::with('dataAchievments')->get();
        
        if (!is_null($this->class)) {
            $students = Student::with('dataAchievments')->whereClassId($this->class)->get();
        }
        $reports = [];

        foreach ($students as $student) {
            $reports[] = [
                'name' => $student->name,
                'class' => $student->class->code,
                'achievmentsCount' => $student->dataAchievments->count(),
                'totalPoint' => $this->generatePoint($student->dataAchievments)
            ];
        }

        return view(
            'app.data_achievments.export',
            compact('reports')
        );
        
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

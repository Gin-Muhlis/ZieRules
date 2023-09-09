<?php

namespace App\Exports;

use App\Models\Student;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ViolationExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $class;

    public function __construct($classFilter) {
        $this->class = $classFilter;
    }
    
    public function view(): View
    {
       
        $students = Student::with('studentAbsences')->get();
        
        if (!is_null($this->class)) {
            $students = Student::with('studentAbsences')->whereClassId($this->class)->get();
        }
        $reports = [];

        foreach ($students as $student) {
            $reports[] = [
                'class' => $student->class_id,
                'name' => $student->name,
                'violationsCount' => $student->dataViolations->count(),
                'totalPoint' => $this->generatePoint($student->dataVIolations)
            ];
        }

        return view(
            'app.data_violations.export',
            compact('reports')
        );
        
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Jumlah Pelanggaran',
            'Total Poin',
        ];
    }

    private function generatePoint($data)
    {
        $point = 0;
        foreach ($data as $dataViolation) {
            $point += $dataViolation->violation->point;
        }

        return $point;
    }
}

<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\ClassStudent;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TaskExport implements FromView
{
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
                'className' => $student->class->name,
                'name' => $student->name,
                'tasksCount' => $student->dataTasks->count(),
            ];
        }

        return view(
            'app.data_tasks.export',
            compact('reports')
        );
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Jumlah Tugas',
            'Total Poin',
        ];
    }

    private function generatePoint($data)
    {
        $point = 0;
        foreach ($data as $dataTask) {
            $point += $dataTask->task->point;
        }

        return $point;
    }
}

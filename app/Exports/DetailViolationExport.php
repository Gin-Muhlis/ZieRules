<?php

namespace App\Exports;

use App\Models\DataViolation;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DetailViolationExport implements FromView
{
    private $student_id;

    public function __construct($id)
    {
        $this->student_id = $id;
    }
    public function view(): View
    {

        $student = Student::findOrFail($this->student_id);

        $dataViolations = DataViolation::with('violation')->whereStudentId($student->id)->latest()->get();

        $reports = [];

        foreach ($dataViolations as $data) {
            $reports[] = [
                'student' => $student->name,
                'date' => $data->date->toDateString(),
                'violation' => $data->violation->name,
                'point' => $data->violation->point
            ];
        }

        return view(
            'app.data_violations.detail',
            compact('reports')
        );

        return view('exports.invoices', compact('reports'));
    }
}

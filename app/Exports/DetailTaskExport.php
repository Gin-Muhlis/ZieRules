<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\DataTask;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DetailTaskExport implements FromView
{
    private $student_id;

    public function __construct($id)
    {
        $this->student_id = $id;
    }

    public function view(): View
    {

        $student = Student::findOrFail($this->student_id);
        $dataTasks = DataTask::with('task')->whereStudentId($student->id)->latest()->get();

        $reports = [];

        foreach ($dataTasks as $data) {
            $reports[] = [
                'student' => $student->name,
                'date' => $data->date->toDateString(),
                'task' => $data->task->name
            ];
        }

        return view(
            'app.data_tasks.export-detail',
            compact('reports')
        );

    }
}

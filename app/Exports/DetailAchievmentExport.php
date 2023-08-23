<?php

namespace App\Exports;

require_once app_path() . '/helpers/helpers.php';

use App\Models\DataAchievment;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DetailAchievmentExport implements FromView
{
    private $student_id;

    public function __construct($id)
    {
        $this->student_id = $id;
    }
    public function view(): View
    {

        $student = Student::findOrFail($this->student_id);

        $dataAchievments = DataAchievment::with('achievment')->whereStudentId($student->id)->latest()->get();

        $reports = [];

        foreach ($dataAchievments as $data) {
            $reports[] = [
                'student' => $student->name,
                'date' => generateDate($data->date->toDateString()),
                'achievment' => $data->achievment->name,
                'point' => $data->achievment->point
            ];
        }

        return view(
            'app.data_achievments.detail',
            compact('reports')
        );

    }
}

<?php

namespace App\Exports;

require_once app_path() . '/helpers/helpers.php';

use App\Models\DataTask;
use Maatwebsite\Excel\Concerns\FromCollection;

class DataTaskExport implements FromCollection
{
    private $start_date;
    private $end_date;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->start_date = $startDate;
        $this->end_date = $endDate;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if (!is_null($this->start_date) && !is_null($this->end_date)) {
            return DataTask::with(['task', 'teacher', 'student'])->whereBetween('date', [$this->start_date, $this->end_date])->get()->map(
                function ($dataTask) {
                    return [
                        'Nama Tugas' => $dataTask->task->name,
                        'Nama Siswa' => $dataTask->student->name,
                        'Nama Guru' => $dataTask->teacher->name,
                        'Tanggal' => generateDate($dataTask->date->toDateString()),
                        'Deskripsi' => $dataTask->description
                    ];
                }
            );
        }
        return DataTask::with(['task', 'teacher', 'student'])->get()->map(
            function ($dataTask) {
                return [
                    'Nama Tugas' => $dataTask->task->name,
                    'Nama Siswa' => $dataTask->student->name,
                    'Nama Guru' => $dataTask->teacher->name,
                    'Tanggal' => generateDate($dataTask->date->toDateString()),
                    'Deskripsi' => $dataTask->description
                ];
            }
        );
    }
}

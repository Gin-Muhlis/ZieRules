<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;

class TaskExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       
        return Student::with(['dataTaks'])->get()->map(
            function ($student) {
                return [
                    'Nama Siswa' => $student->name,
                    'Jumlah Pelanggaran' => $student->dataTask->count(),
                    'Total Poin' => $this->generatePoint($student->dataTask),
                ];
            }
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

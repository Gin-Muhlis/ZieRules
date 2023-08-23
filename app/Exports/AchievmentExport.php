<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;

class AchievmentExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Student::with(['dataAchievments'])->get()->map(
            function ($student) {
                return [
                    'Nama Siswa' => $student->name,
                    'Jumlah Pelanggaran' => $student->dataAchievments->count(),
                    'Total Poin' => $this->generatePoint($student->dataAchievments),
                ];
            }
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

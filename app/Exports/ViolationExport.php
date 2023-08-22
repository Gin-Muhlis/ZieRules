<?php

namespace App\Exports;

use App\Models\DataViolation;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;

class ViolationExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
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
       
        return Student::with(['dataViolations'])->get()->map(
            function ($student) {
                return [
                    'Nama Siswa' => $student->name,
                    'Jumlah Pelanggaran' => $student->dataViolations->count(),
                    'Total Poin' => $this->generatePoint($student->dataViolations),
                ];
            }
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

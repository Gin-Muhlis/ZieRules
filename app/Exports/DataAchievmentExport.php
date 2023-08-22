<?php

namespace App\Exports;

use App\Models\DataAchievment;
use Maatwebsite\Excel\Concerns\FromCollection;

require_once app_path() . '/helpers/helpers.php';
class DataAchievmentExport implements FromCollection
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
            return DataAchievment::with(['achievment', 'teacher', 'student'])->whereBetween('date', [$this->start_date, $this->end_date])->get()->map(
                function ($dataAchievment) {
                    return [
                        'Nama Prestasi' => $dataAchievment->achievment->name,
                        'Nama Siswa' => $dataAchievment->student->name,
                        'Nama Guru (Pelopor)' => $dataAchievment->teacher->name,
                        'Tanggal' => generateDate($dataAchievment->date->toDateString()),
                        'Deskripsi' => $dataAchievment->description
                    ];
                }
            );
        }
        return DataAchievment::with(['achievment', 'teacher', 'student'])->get()->map(
            function ($dataAchievment) {
                return [
                    'Nama Prestasi' => $dataAchievment->achievment->name,
                    'Nama Siswa' => $dataAchievment->student->name,
                    'Nama Guru (Pelopor)' => $dataAchievment->teacher->name,
                    'Tanggal' => generateDate($dataAchievment->date->toDateString()),
                    'Deskripsi' => $dataAchievment->description
                ];
            }
        );
    }
}
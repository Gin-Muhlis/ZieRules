<?php

namespace App\Exports;

use App\Models\Student;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


class AchievmentExport implements FromView, WithTitle, WithEvents
{
    private $class;

    public function __construct($classFilter)
    {
        $this->class = $classFilter;
    }
    public function view(): View
    {

        $students = Student::with('dataAchievments')->whereClassId($this->class->id)->get();

        $reports = [];

        foreach ($students as $student) {
            $reports[] = [
                'name' => $student->name,
                'class' => $student->class->code,
                'achievmentsCount' => $student->dataAchievments->count(),
                'totalPoint' => $this->generatePoint($student->dataAchievments)
            ];
        }

        return view(
            'app.data_achievments.export',
            compact('reports')
        );
    }

    public function title(): string
    {
        return 'Data Prestasi Siswa';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getColumnDimension('A')->setWidth(5);
                $event->sheet->getColumnDimension('B')->setWidth(50);
                $event->sheet->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getColumnDimension('D')->setAutoSize(true);

                $event->sheet->insertNewRowBefore(1, 3);
                $event->sheet->mergeCells('A1:D1');
                $event->sheet->mergeCells('A2:D2');
                $event->sheet->setCellValue('A1', 'DATA PRESTASI SISWA ' . $this->class->code);

                $event->sheet->getStyle('A1:D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('C')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('D')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $event->sheet->getStyle('A4:D4')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'd6d8db'
                        ]
                    ]
                ]);

                $event->sheet->getStyle('A4:' . $event->sheet->getHighestColumn() . $event->sheet->getHighestRow())->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            }
        ];
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

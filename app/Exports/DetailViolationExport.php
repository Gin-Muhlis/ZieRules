<?php

namespace App\Exports;

require_once app_path() . '/helpers/helpers.php';

use App\Models\DataViolation;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class DetailViolationExport implements FromView, WithTitle, WithEvents
{
    private $dataStudent;
    private $totalPoint = 0;
    public function __construct($id)
    {
        $this->dataStudent = Student::findOrFail($id);
    }
    public function view(): View
    {

        $dataViolations = DataViolation::with('violation')->whereStudentId($this->dataStudent->id)->latest()->get();

        $reports = [];

        foreach ($dataViolations as $data) {
            $this->totalPoint += $data->violation->point;
            $reports[] = [
                'student' => $this->dataStudent->name,
                'date' => $data->date->toDateString(),
                'violation' => $data->violation->name,
                'point' => $data->violation->point
            ];
        }

        $total_point = $this->totalPoint;

        return view(
            'app.data_violations.export-detail',
            compact('reports', 'total_point')
        );

    }

    public function title(): string
    {
        return 'Data Pelanggaran Siswa';
    }

     public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getColumnDimension('A')->setWidth(5);
                $event->sheet->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getColumnDimension('D')->setAutoSize(true);
                $event->sheet->getColumnDimension('E')->setAutoSize(true);

                $event->sheet->insertNewRowBefore(1, 3);
                $event->sheet->mergeCells('A1:D1');
                $event->sheet->mergeCells('A2:D2');
                $event->sheet->setCellValue('A1', 'DATA PELANGGARAN ' . $this->dataStudent->name);

   
                $event->sheet->getStyle('A1:D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('C')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('D')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('E')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                
                $event->sheet->getStyle('A4:E4')->applyFromArray([
                    'fill' => [
                        'fillType' =>\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
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

}

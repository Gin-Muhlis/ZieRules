<?php

namespace App\Exports;

require_once app_path() . '/helpers/helpers.php';

use App\Models\Student;
use App\Models\DataAchievment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class DetailAchievmentExport implements FromView, WithTitle, WithEvents
{
    private $dataStudent;
    private $totalPoint = 0;

    public function __construct($id)
    {
        $this->dataStudent = Student::findOrFail($id);
    }
    public function view(): View
    {

        $dataAchievments = DataAchievment::with('achievment')->whereStudentId($this->dataStudent->id)->latest()->get();

        $reports = [];

        foreach ($dataAchievments as $data) {
            $this->totalPoint += $data->achievment->point;
            $reports[] = [
                'student' => $this->dataStudent->name,
                'date' => $data->date->toDateString(),
                'achievment' => $data->achievment->name,
                'point' => $data->achievment->point
            ];
        }

        $total_point = $this->totalPoint;

        return view(
            'app.data_achievments.export-detail',
            compact('reports', 'total_point')
        );

    }

    public function title(): string
    {
        return 'Data Prestasi Siswa';
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
                $event->sheet->setCellValue('A1', 'Data Prestasi ' . $this->dataStudent->name);

   
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

<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\DataTask;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class DetailTaskExport implements FromView, WithTitle, WithEvents
{
    private $dataStudent;

    public function __construct($id)
    {
        $this->dataStudent = Student::findOrFail($id);
    }

    public function view(): View
    {

        $dataTasks = DataTask::with('task')->whereStudentId($this->dataStudent->id)->latest()->get();

        $reports = [];

        foreach ($dataTasks as $data) {
            $reports[] = [
                'student' => $this->dataStudent->name,
                'date' => $data->date->toDateString(),
                'task' => $data->task->name
            ];
        }

        return view(
            'app.data_tasks.export-detail',
            compact('reports')
        );

    }

    public function title(): string
    {
        return 'Data Tugas Siswa';
    }

     public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getColumnDimension('A')->setWidth(5);
                $event->sheet->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getColumnDimension('D')->setAutoSize(true);

                $event->sheet->insertNewRowBefore(1, 3);
                $event->sheet->mergeCells('A1:D1');
                $event->sheet->mergeCells('A2:D2');
                $event->sheet->setCellValue('A1', 'DATA TUGAS ' . $this->dataStudent->name);
                
                $event->sheet->getStyle('A1:D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('C')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('D')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                
                $event->sheet->getStyle('A4:D4')->applyFromArray([
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

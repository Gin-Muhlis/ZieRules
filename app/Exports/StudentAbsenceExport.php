<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\StudentAbsence;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class StudentAbsenceExport implements FromView, WithTitle, WithEvents
{

    private $class;

    public function __construct($classFilter)
    {
        $this->class = $classFilter;
    }
    public function view(): View
    {

        $students = Student::with('studentAbsences')->whereClassId($this->class->id)->get();

        $reports = [];

        foreach ($students as $student) {
            $presences = 0;
            $permissions = 0;
            $sicks = 0;
            $withoutExplanations = 0;
            $absences = StudentAbsence::whereStudentId($student->id)->get();
            foreach ($absences as $absence) {
                $presences = strtolower($absence->presence->name) == 'hadir' ? $presences + 1 : $presences;
                $permissions = strtolower($absence->presence->name) == 'izin' ? $permissions + 1 : $permissions;
                $sicks = strtolower($absence->presence->name) == 'sakit' ? $sicks + 1 : $sicks;
                $withoutExplanations = strtolower($absence->presence->name) == 'tanpa keterangan' ? $withoutExplanations + 1 : $withoutExplanations;
            }
            $reports[] = [
                'student_id' => $student->id,
                'name' => $student->name,
                'presences' => $presences,
                'permissions' => $permissions,
                'sicks' => $sicks,
                'withoutExplanations' => $withoutExplanations,
            ];
        }

        return view(
            'app.student_absences.export',
            compact('reports')
        );
    }

    public function title(): string
    {
        return 'Data Kehadiran Siswa';
    }

     public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getColumnDimension('A')->setWidth(5);
                $event->sheet->getColumnDimension('B')->setWidth(50);
                $event->sheet->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getColumnDimension('D')->setAutoSize(true);
                $event->sheet->getColumnDimension('E')->setAutoSize(true);
                $event->sheet->getColumnDimension('F')->setAutoSize(true);

                $event->sheet->insertNewRowBefore(1, 3);
                $event->sheet->mergeCells('A1:F1');
                $event->sheet->mergeCells('A2:F2');
                $event->sheet->setCellValue('A1', 'DATA KEHADIRAN SISWA ' . $this->class->code);
                
                $event->sheet->getStyle('A1:F2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('C')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('D')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('E')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('F')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                
                $event->sheet->getStyle('A4:F4')->applyFromArray([
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

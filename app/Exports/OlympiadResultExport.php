<?php

namespace App\Exports;

use App\Models\Olympiad;
use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OlympiadResultExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithColumnWidths, WithColumnFormatting, WithEvents
{
    use Exportable;

    /**
     * @var Olympiad
     */
    protected $olympiad;

    /**
     * @var Collection
     */
    protected $results;

    /**
     * @param Collection $results
     */
    public function __construct(Olympiad $olympiad, Collection $results)
    {
        $this->olympiad = $olympiad;
        $this->results = $results;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->results;
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'D' => '+#'
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            [
                __('Results of the Olympiad ":title", which was held on :date from :start to :end', [
                    'title' => $this->olympiad->title,
                    'date' => $this->olympiad->starts_at->format('d.m.Y'),
                    'start' => $this->olympiad->starts_at->format('H:i'),
                    'end' => $this->olympiad->ends_at->format('H:i'),
                ])
            ],
            [
                'ID',
                __('Name'),
                __('Gender'),
                __('Phone'),
                __('Date of birth'),
                __('Region'),
                __('District'),
                __('Institution'),
                __('Grade'),
                __('Score'),
                __('Started at'),
                __('Finished at'),
                __('Time spent')
            ]
        ];
    }

    /**
     * @param mixed $model
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->fullname,
            $row->student->gender === Student::GENDER_MALE ? __('Male') : __('Female'),
            $row->student->user->phone,
            $row->student->date_of_birth,
            $row->student->region->name,
            $row->student->district->name,
            $row->student->institution->name,
            $row->student->grade,
            $row->score,
            $row->created_at->formatted,
            $row->finished_at ? $row->finished_at->formatted : '',
            __(':min minutes', ['min' => $row->time])
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->mergeCells('A1:K1');
            },
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array[]
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => [
                    'bold' => true
                ],
            ],
            2 => [
                'font' => [
                    'bold' => true
                ],
            ]
        ];
    }
}

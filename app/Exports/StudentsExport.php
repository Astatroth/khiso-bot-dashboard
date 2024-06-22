<?php

namespace App\Exports;

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
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithColumnWidths, WithColumnFormatting
{
    use Exportable;

    /**
     * @var Collection
     */
    protected $results;

    /**
     * @param Collection $results
     */
    public function __construct(Collection $results)
    {
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
                'ID',
                __('Name'),
                __('Gender'),
                __('Phone'),
                __('Date of birth'),
                __('Region'),
                __('District'),
                __('Institution'),
                __('Grade'),
                __('Registered at')
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
            $row->gender === Student::GENDER_MALE ? __('Male') : __('Female'),
            $row->user->phone,
            $row->date_of_birth,
            $row->region->name,
            $row->district->name,
            $row->institution->name,
            $row->grade,
            $row->created_at->formatted
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
            ]
        ];
    }
}

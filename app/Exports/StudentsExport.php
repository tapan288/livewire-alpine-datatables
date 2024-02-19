<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function __construct(public array $studentIds)
    {
        //
    }

    public function query()
    {
        return Student::query()->whereIn('id', $this->studentIds);
    }

    public function map($student): array
    {
        return [
            $student->name,
            $student->email,
            $student->class->name,
            $student->section->name,
            $student->created_at->toDateString(),
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Class',
            'Section',
            'Created At',
        ];
    }
}

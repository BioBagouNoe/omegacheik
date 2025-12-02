<?php

namespace App\Exports;

use App\Models\Line;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LinesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Line::all(['id', 'name_line']);
    }

    public function headings(): array
    {
        return [
            'id',
            'name_line',
        ];
    }
}

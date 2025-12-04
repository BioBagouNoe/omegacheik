<?php
namespace App\Exports;

use App\Models\Ship;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ShipsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Ship::with('line')->get()->map(function($ship) {
            return [
                'navire' => $ship->name_nav,
                'ligne' => $ship->line ? $ship->line->name_line : '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'navire',
            'ligne',
        ];
    }
}

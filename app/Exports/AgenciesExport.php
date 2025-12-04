<?php

namespace App\Exports;

use App\Models\Agency;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AgenciesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Agency::with(['line', 'pays'])->get()->map(function($agency) {
            return [
                'ID' => $agency->id,
                'Nom de l\'agence' => $agency->name_agency,
                'Ligne' => $agency->line->name_line ?? '',
                'Pays' => $agency->pays->nom ?? '',
                'Adresse' => $agency->adress_agency,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nom de l\'agence',
            'Ligne',
            'Pays',
            'Adresse',
        ];
    }
}

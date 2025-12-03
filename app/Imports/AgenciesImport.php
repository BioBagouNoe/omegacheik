<?php

namespace App\Imports;

use App\Models\Agency;
use App\Models\Line;
use App\Models\Pays;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AgenciesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $line = \App\Models\Line::where('name_line', $row['ligne'] ?? $row['line'] ?? $row['nom_de_la_ligne'] ?? null)->first();
        $pays = \App\Models\Pays::where('nom', $row['pays'] ?? $row['nom_du_pays'] ?? null)->first();
        return new \App\Models\Agency([
            'name_agency' => $row['nom_de_lagence'] ?? $row['agence'] ?? $row['name_agency'] ?? null,
            'adress_agency' => $row['adresse'] ?? $row['adress_agency'] ?? null,
            'line_id' => $line ? $line->id : null,
            'pays_id' => $pays ? $pays->id : null,
        ]);
    }
}

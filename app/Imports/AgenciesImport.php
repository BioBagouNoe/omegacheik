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
        $line = Line::where('name_line', $row['ligne'])->first();
        $pays = Pays::where('name', $row['pays'])->first();
        return new Agency([
            'name_agency' => $row['nom_de_lagence'],
            'adress_agency' => $row['adresse'],
            'line_id' => $line ? $line->id : null,
            'pays_id' => $pays ? $pays->id : null,
        ]);
    }
}

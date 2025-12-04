<?php

namespace App\Imports;

use App\Models\Agency;
use App\Models\Line;
use App\Models\Pays;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;

class AgenciesImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    public $errors = [];

    public function model(array $row)
    {
        $lineName = $row['ligne'] ?? $row['line'] ?? $row['nom_de_la_ligne'] ?? null;
        $paysName = $row['pays'] ?? $row['nom_du_pays'] ?? null;
        $line = \App\Models\Line::where('name_line', $lineName)->first();
        $pays = \App\Models\Pays::where('nom', $paysName)->first();

        if (!$line) {
            $this->errors[] = "Ligne non trouvée: '$lineName' (agence: " . ($row['nom_de_lagence'] ?? $row['agence'] ?? $row['name_agency'] ?? '') . ")";
        }
        if (!$pays) {
            $this->errors[] = "Pays non trouvé: '$paysName' (agence: " . ($row['nom_de_lagence'] ?? $row['agence'] ?? $row['name_agency'] ?? '') . ")";
        }
        if (!$line || !$pays) {
            return null;
        }
        return new \App\Models\Agency([
            'name_agency' => $row['nom_de_lagence'] ?? $row['agence'] ?? $row['name_agency'] ?? null,
            'adress_agency' => $row['adresse'] ?? $row['adress_agency'] ?? null,
            'line_id' => $line->id,
            'pays_id' => $pays->id,
        ]);
    }
}

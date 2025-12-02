<?php

namespace App\Imports;

use App\Models\Line;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LinesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Line([
            'name_line' => $row['nom_ligne'],
        ]);
    }
}

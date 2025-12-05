<?php
namespace App\Imports;

use App\Models\Ship;
use App\Models\Line;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ShipsImport implements ToModel, WithHeadingRow
{
    public $errors = [];

    public function model(array $row)
    {
        $line = Line::where('name_line', $row['ligne'])->first();
        if (!$line) {
            $this->errors[] = "Ligne non trouvée: '{$row['ligne']}' (navire: " . ($row['navire'] ?? '') . ")";
            return null;
        }
        return new Ship([
            'name_nav' => $row['navire'],
            'line_id' => $line->id,
        ]);
    }
}

<?php
namespace App\Imports;

use App\Models\Ship;
use App\Models\Line;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ShipsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $line = Line::where('name_line', $row['ligne'])->first();
        return new Ship([
            'name_nav' => $row['navire'],
            'line_id' => $line ? $line->id : null,
        ]);
    }
}

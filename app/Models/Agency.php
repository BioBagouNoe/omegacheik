<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $fillable = ['name_agency', 'adress_agency', 'line_id'];

    public function line()
    {
        return $this->belongsTo(Line::class);
    }
}

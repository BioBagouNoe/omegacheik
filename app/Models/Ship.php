<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    protected $fillable = ['name_nav', 'line_id'];

    public function line()
    {
        return $this->belongsTo(Line::class);
    }
}

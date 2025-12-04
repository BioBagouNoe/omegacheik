<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pays extends Model
{
    public function agencies()
    {
        return $this->hasMany(Agency::class);
    }
}

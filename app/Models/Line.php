<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    use HasFactory;
    protected $fillable = ['name_line'];

    public function agencies()
    {
        return $this->hasMany(Agency::class);
    }
}

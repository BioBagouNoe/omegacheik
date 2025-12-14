<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    protected $table = 'travel';
    protected $fillable = [
        'num_travel',
        'arrival_date',
        'docking_date',
        'end_unloading',
        'status',
        'agency_id',
        'ship_id',
    ];

    // Relations
    public function travelDetails()
    {
       // return $this->hasMany(Travel_detail::class, 'travel_id');
    }

    public function agency()
    {
        return $this->belongsTo(\App\Models\Agency::class, 'agency_id');
    }

    public function ship()
    {
        return $this->belongsTo(\App\Models\Ship::class, 'ship_id');
    }

    // Méthodes métier
    public static function registerTravel($data)
    {
        return self::create($data);
    }

    public function updateTravel($data)
    {
        $this->update($data);
        return $this;
    }

    public function deleteTravel()
    {
        return $this->delete();
    }
}

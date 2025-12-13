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
    ];

    // Relations
    public function travelDetails()
    {
        return $this->hasMany(Travel_detail::class, 'travel_id');
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

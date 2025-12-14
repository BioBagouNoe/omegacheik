<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelDetail extends Model
{
    protected $table = 'travel_details';
    protected $fillable = [
        'bar_code',
        'bl',
        'consignor',
        'destination',
        'consignor_adress',
        'chassis',
        'mark',
        'type',
        'year_make',
        'travel_id',
    ];

    public function travel()
    {
        return $this->belongsTo(Travel::class, 'travel_id');
    }
}

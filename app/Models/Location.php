<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'city',
        'region',
        'country',
        'postal_code',
    ];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}

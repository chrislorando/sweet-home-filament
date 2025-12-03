<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacteristicProperty extends Model
{
    protected $table = 'characteristic_property';

    protected $fillable = [
        'characteristic_id',
        'property_id',
        'value',
    ];

    public function characteristic()
    {
        return $this->belongsTo(Characteristic::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}

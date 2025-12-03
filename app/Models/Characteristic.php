<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Characteristic extends Model
{
    protected $fillable = [
        'name',
        'type',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function properties()
    {
        return $this->belongsToMany(Property::class)->withPivot('value');
    }
}

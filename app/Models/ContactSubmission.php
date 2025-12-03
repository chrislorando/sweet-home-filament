<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'firstname',
        'lastname',
        'address',
        'postcode',
        'email',
        'phone',
        'message',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}

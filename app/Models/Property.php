<?php

namespace App\Models;

use App\Enums\Availability;
use App\Enums\Condition;
use App\Enums\ListingType;
use App\Enums\PropertyStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'address',
        'description',
        'price',
        'size',
        'rooms',
        'location_id',
        'category_id',
        'status',
        'rejection_notes',
        'condition',
        'property_type',
        'availability',
        'living_area',
        'cubic_area',
        'plot_size',
        'construction_year',
        'immocode',
        'property_number',
        'document',
        'document_name',
        'latitude',
        'longitude',
        'maps',
        'floor',
        'last_renovation',
        'listing_type',
        'requested_at',
        'approved_at',
        'approved_by',
        'rejected_at',
        'rejected_by',
    ];

    /**
     * Cast model attributes to types / enum classes.
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'status' => PropertyStatus::class,
            'availability' => Availability::class,
            'condition' => Condition::class,
            'listing_type' => ListingType::class,
            'maps' => 'array',
            'requested_at' => 'datetime',
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
        ]);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->user_id && auth()->check()) {
                $model->user_id = auth()->id();
            }

            $model->slug = Str::slug($model->title);
        });

        static::updating(function ($model) {
            $model->slug = Str::slug($model->title);
        });
    }

    public function approve()
    {
        $this->status = PropertyStatus::Approved;
        $this->approved_at = now();
        $this->approved_by = auth()->id();
        $this->save();
    }

    public function reject($notes)
    {
        $this->status = PropertyStatus::Rejected;
        $this->rejection_notes = $notes;
        $this->rejected_at = now();
        $this->rejected_by = auth()->id();
        $this->save();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function characteristics()
    {
        return $this->belongsToMany(Characteristic::class)->withPivot('value');
    }

    public function thumbnail()
    {
        return $this->hasOne(PropertyImage::class);
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function contactSubmissions()
    {
        return $this->hasMany(ContactSubmission::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }
}

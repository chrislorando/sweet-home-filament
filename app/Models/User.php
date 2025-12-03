<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    public function canAccessPanel(Panel $panel): bool
    {
        // if ($panel->getId() === 'admin') {
        //     return $this->role === UserRole::Admin;
        // }

        // if ($panel->getId() === 'provider') {
        //     return $this->role === UserRole::Provider;
        // }

        return true;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'slug',
        'password',
        'role',
        'company_name',
        'description',
        'address',
        'services',
        'phone',
        'website',
        'avatar',
    ];

    /**
     * Cast model attributes to types / enum classes.
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'role' => UserRole::class,
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'deleted_at' => 'datetime',
            'services' => 'array',
        ]);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (! $user->slug) {
                $baseSlug = Str::slug($user->company_name ?? $user->name);
                $slug = $baseSlug;
                $count = 1;

                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug.'-'.$count;
                    $count++;
                }

                $user->slug = $slug;
            }
        });

        static::updating(function ($user) {
            if ($user->isDirty('company_name') || $user->isDirty('name')) {
                $baseSlug = Str::slug($user->company_name ?? $user->name);
                $slug = $baseSlug;
                $count = 1;

                while (static::where('slug', $slug)->where('id', '!=', $user->id)->exists()) {
                    $slug = $baseSlug.'-'.$count;
                    $count++;
                }

                $user->slug = $slug;
            }
        });
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    public function isFreelancer(): bool
    {
        return $this->role === UserRole::Provider;
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ...existing code above covers casts()
}

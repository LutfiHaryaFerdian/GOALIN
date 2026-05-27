<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Role helpers
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    // Relationships
    public function fields(): HasMany
    {
        return $this->hasMany(Field::class, 'owner_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Override Notifiable::notifications() — GOALIN uses a custom
     * notifications table with user_id (not polymorphic notifiable_type/id).
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id')->latest();
    }

    public function unreadNotifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id')
                    ->whereNull('read_at')
                    ->latest();
    }
}

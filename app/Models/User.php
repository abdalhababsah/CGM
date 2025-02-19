<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Extending Authenticatable for authentication
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Mass assignable attributes
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'google_id',
        'role',
    ];
    // Hidden attributes for arrays
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Cast attributes
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships

    // A user can have many orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // A user can have one cart
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    // A user can have many wish lists
    public function wishLists()
    {
        return $this->hasMany(WishList::class);
    }

    // A user can have many notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function getNameAttribute()
    {
        return ucfirst($this->first_name).' '.ucfirst($this->last_name);
    }
}

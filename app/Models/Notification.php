<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = [
        'user_id',
        'language',
        'message',
        'is_read',
    ];

    // Relationships

    // A notification belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

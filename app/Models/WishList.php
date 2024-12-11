<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = [
        'user_id',
    ];

    // Relationships

    // A wish list belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A wish list can have many wish list items
    public function wishListItems()
    {
        return $this->hasMany(WishListItem::class);
    }
}

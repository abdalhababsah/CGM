<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountCode extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     * 
     * Optional: Laravel automatically assumes the table name is the plural
     * form of the model name. If your table name follows this convention,
     * you can omit this property.
     *
     * @var string
     */
    protected $table = 'discount_codes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'type',
        'amount',
        'usage_limit',
        'times_used',
        'expiry_date',
        'is_active',
    ];

    /**
     * The attributes that should be cast to native types.
     * This ensures that attributes are automatically converted
     * to the specified type when accessed.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'float',
        'usage_limit' => 'integer',
        'times_used' => 'integer',
        'expiry_date' => 'date',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime', 
    ];

    /**
     * The attributes that should be mutated to dates.
     * Deprecated in favor of $casts, but kept for backward compatibility.
     *
     * @var array<int, string>
     */
    protected $dates = [
        'expiry_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get the orders that have used this discount code.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'discount_code_id');
    }

    /**
     * Scope a query to only include active discount codes.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    public function scopeActive($query)
    {
        $query->where('is_active', true)
              ->where(function($q) {
                  $q->whereNull('expiry_date')
                    ->orWhere('expiry_date', '>=', now());
              })
              ->where(function($q) {
                  $q->whereNull('usage_limit')
                    ->orWhere('times_used', '<', 'usage_limit');
              });
    }

    /**
     * Check if the discount code is still valid.
     *
     * @return bool
     */
    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expiry_date && now()->isAfter($this->expiry_date)) {
            return false;
        }

        if ($this->usage_limit && $this->times_used >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    /**
     * Increment the times_used counter.
     *
     * @return void
     */
    public function incrementUsage()
    {
        $this->increment('times_used');
    }

    /**
     * Accessor for formatted amount based on type.
     *
     * @return string
     */
    public function getFormattedAmountAttribute()
    {
        return $this->type === 'fixed' ? '$' . number_format($this->amount, 2) : $this->amount . '%';
    }

    /**
     * Mutator to ensure the discount code is always stored in uppercase.
     *
     * @param string $value
     * @return void
     */
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }
}
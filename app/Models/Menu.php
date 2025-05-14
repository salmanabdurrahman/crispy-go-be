<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $table = 'menus';

    protected $guarded = [
        'id'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeBestseller(Builder $query): Builder
    {
        return $query->where('is_bestseller', '=', true);
    }
}

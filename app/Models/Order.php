<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';

    protected $guarded = [
        'id'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function getTotalPriceAttribute()
    {
        return $this->items->sum(fn($item) => $item->price * $item->quantity);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}

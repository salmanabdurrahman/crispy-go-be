<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsletterSubscription extends Model
{
    use SoftDeletes;

    protected $table = 'newsletter_subscriptions';

    protected $guarded = [
        'id'
    ];

    protected $dates = [
        'deleted_at'
    ];
}

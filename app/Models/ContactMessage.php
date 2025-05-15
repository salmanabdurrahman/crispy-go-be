<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactMessage extends Model
{
    use SoftDeletes;

    protected $table = 'contact_messages';

    protected $guarded = [
        'id'
    ];

    protected $dates = [
        'deleted_at'
    ];
}

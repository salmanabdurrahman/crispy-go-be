<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use SoftDeletes;

    protected $table = 'blog_posts';

    protected $guarded = [
        'id'
    ];

    protected $dates = [
        'deleted_at',
        'published_at'
    ];

    protected static function booted()
    {
        static::creating(function ($post) {
            $post->slug = Str::slug($post->title);
            $post->excerpt = Str::limit(strip_tags($post->content), 200);
        });

        static::saving(function ($post) {
            $post->slug = Str::slug($post->title);
            $post->excerpt = Str::limit(strip_tags($post->content), 200);
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}


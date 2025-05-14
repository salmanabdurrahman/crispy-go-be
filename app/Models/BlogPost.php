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

    public function setTitleAttribute(string $value): void
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function setExcerptAttribute(string $value): void
    {
        $this->attributes['content'] = $value;
        $this->attributes['excerpt'] = Str::limit(strip_tags($value), 200);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}


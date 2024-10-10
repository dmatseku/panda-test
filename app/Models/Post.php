<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $fillable = ['sku', 'price'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(Subscriber::class, 'posts_subscribers', 'post_id', 'subscriber_id');
    }

    public function alias(): HasMany
    {
        return $this->hasMany(Alias::class, 'post_id', 'id');
    }
}

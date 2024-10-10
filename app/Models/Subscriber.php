<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Subscriber extends Model
{
    protected $fillable = ['email', 'confirmed'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'posts_subscribers', 'subscriber_id', 'post_id');
    }

    public function verification(): HasOne
    {
        return $this->hasOne(Verification::class, 'subscriber_id', 'id');
    }
}

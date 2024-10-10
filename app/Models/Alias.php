<?php

namespace App\Models;

use App\Contracts\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Http;

class Alias extends Model
{
    protected $fillable = ['post_id', 'alias'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}

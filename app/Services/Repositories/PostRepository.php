<?php

namespace App\Services\Repositories;

use App\Contracts\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class PostRepository implements PostRepositoryInterface
{

    public function create($sku, $price)
    {
        return Post::create(['sku' => $sku, 'price' => $price]);
    }

    public function get($value, $attribute = 'id')
    {
        if ($attribute === 'id') {
            return Post::find($value);
        }

        return Post::where($attribute, $value)->first();
    }

    public function all($whereCondition = ""): Collection
    {
        if (!empty($whereCondition)) {
            return Post::where($whereCondition);
        }
        return Post::all();
    }

    public function save($post)
    {
        return $post->save();
    }

    public function delete($post)
    {
        return $post->delete();
    }
}
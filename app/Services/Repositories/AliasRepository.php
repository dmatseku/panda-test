<?php

namespace App\Services\Repositories;

use App\Contracts\AliasRepositoryInterface;
use App\Models\Alias;

class AliasRepository implements AliasRepositoryInterface
{
    public function create($url)
    {
        // TODO: Implement create() method.
    }

    public function get($value, $attribute = 'id')
    {
        if ($attribute === 'id') {
            return Alias::find($value);
        }

        return Alias::where($attribute, $value)->first();
    }

    public function save($alias)
    {
        return $alias->save();
    }

    public function delete($alias)
    {
        return $alias->delete();
    }
}
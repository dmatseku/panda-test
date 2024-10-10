<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface PostRepositoryInterface
{
    public function create($sku, $price);

    public function get($value, $attribute = 'id');

    public function all($whereCondition = ""): Collection;

    public function save($post);

    public function delete($post);
}
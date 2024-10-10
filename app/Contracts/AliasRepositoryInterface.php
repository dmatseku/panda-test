<?php

namespace App\Contracts;

interface AliasRepositoryInterface
{
    public function create($url);

    public function get($value, $attribute = 'id');

    public function save($alias);

    public function delete($alias);
}
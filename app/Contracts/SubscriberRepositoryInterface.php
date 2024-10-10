<?php

namespace App\Contracts;

interface SubscriberRepositoryInterface
{
    public function create($email);

    public function get($value, $attribute = 'id');

    public function save($subscriber);

    public function delete($subscriber);
}
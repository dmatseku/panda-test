<?php

namespace App\Contracts;

interface VerificationRepositoryInterface
{
    public function make();

    public function get($value, $attribute = 'id');

    public function save($verification);

    public function delete($verification);
}
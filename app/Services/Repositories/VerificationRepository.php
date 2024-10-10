<?php

namespace App\Services\Repositories;

use App\Contracts\VerificationRepositoryInterface;
use App\Models\Verification;

class VerificationRepository implements VerificationRepositoryInterface
{
    public function make()
    {
        $verification = Verification::make();

        $verification->token = $this->generateToken();

        return $verification;
    }

    protected function generateToken()
    {
        return bin2hex(random_bytes(18));
    }

    public function get($value, $attribute = 'id')
    {
        if ($attribute === 'id') {
            return Verification::find($value);
        }

        return Verification::where($attribute, $value)->first();
    }

    public function save($verification)
    {
        return $verification->save();
    }

    public function delete($verification)
    {
        return $verification->delete();
    }
}
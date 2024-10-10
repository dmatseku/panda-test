<?php

namespace App\Services\Repositories;

use App\Contracts\SubscriberRepositoryInterface;
use App\Contracts\VerificationRepositoryInterface;
use App\Models\Subscriber;

class SubscriberRepository implements SubscriberRepositoryInterface
{
    public function __construct(
        protected VerificationRepositoryInterface $verificationRepository,
    ) {

    }

    public function create($email): Subscriber
    {

        return Subscriber::create(['email' => $email]);
    }

    public function get($value, $attribute = 'id')
    {
        if ($attribute === 'id') {
            return Subscriber::find($value);
        }

        return Subscriber::where($attribute, $value)->first();
    }

    public function save($subscriber)
    {
        return $subscriber->save();
    }

    public function delete($subscriber)
    {
        return $subscriber->delete();
    }
}
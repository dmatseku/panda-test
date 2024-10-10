<?php

namespace App\Services;

use App\Contracts\SubscriberRepositoryInterface;
use App\Contracts\VerificationRepositoryInterface;
use App\Models\Verification;

class VerificationService
{
    public function __construct(
        protected VerificationRepositoryInterface $verificationRepository,
        protected SubscriberRepositoryInterface $subscriberRepository
    ) {

    }

    public function verify($token)
    {
        $verification = $this->verificationRepository->get($token, 'token');
        if (!$verification) {
            return false;
        }

        $email = $verification->subscriber->email;
        $subscriber = $verification->subscriber;

        $subscriber->confirmed = true;
        $this->subscriberRepository->save($subscriber);
        $this->verificationRepository->delete($verification);

        return $email;
    }
}
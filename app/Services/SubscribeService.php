<?php

namespace App\Services;

use App\Contracts\AliasRepositoryInterface;
use App\Contracts\PostRepositoryInterface;
use App\Contracts\SubscriberRepositoryInterface;
use App\Contracts\VerificationRepositoryInterface;
use App\Mail\ConfirmationEmail;
use App\Models\Alias;
use App\Models\Post;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class SubscribeService
{
    public function __construct(
        protected VerificationRepositoryInterface $verificationRepository,
        protected SubscriberRepositoryInterface $subscriberRepository,
        protected AliasRepositoryInterface $aliasRepository,
        protected PostRepositoryInterface $postRepository,
        protected PostApiService $postApiService,
    ) {

    }

    public function subscribe($email, $url)
    {
        /** @var Subscriber $subscriber */
        $subscriber = $this->getSubscriber($email);
        $alias = $this->getAlias($url);

        if (!$subscriber->posts->contains($alias->post)) {
            $subscriber->posts()->attach($alias->post);
        }

        return $subscriber;
    }

    public function unsubscribe($email, $url = null)
    {
        $subscriber = $this->subscriberRepository->get($email, 'email');

        if ($subscriber) {
            if ($url === null) {
                $this->subscriberRepository->delete($subscriber);
            } else {
                $alias = $this->aliasRepository->get($url, 'alias');

                if ($alias) {
                    $post = $alias->post;

                    $subscriber->posts()->detach($post);
                    $this->clearUnusedData($subscriber, $post);
                }
            }
        }
    }

    protected function clearUnusedData($subscriber)
    {
        if ($subscriber->posts->count() === 0) {
            $this->subscriberRepository->delete($subscriber);
        }

        if ($post->subscribers->count() === 0) {
            $this->postRepository->delete($post);
        }
    }

    protected function getSubscriber($email)
    {
        $subscriber = $this->subscriberRepository->get($email, 'email');

        if (!$subscriber) {
            $subscriber = $this->subscriberRepository->create($email);

            if (!$subscriber->confirmed && $subscriber->verification == null) {
                $verification = $this->verificationRepository->make();

                $subscriber->verification()->save($verification);
                Mail::to($subscriber->email)->queue(new ConfirmationEmail($verification->token));
            }
        }

        return $subscriber;
    }

    protected function getAlias($url)
    {
        $alias = $this->aliasRepository->get($url, 'alias');

        if (!$alias) {
            $alias = $this->createPostAndAssociate($url);
        }

        return $alias;
    }

    protected function createPostAndAssociate($url)
    {
        $sku = $this->postApiService->extractSku($url);
        if (!$sku) {
            throw new \Exception('Invalid OLX url');
        }
        $post = $this->postRepository->get($sku, 'sku');

        if (!$post) {
            $price = $this->postApiService->getPostsPrice($sku);
            if ($price === false) {
                throw new \Exception('Unable to extract price');
            }
            $post = $this->postRepository->create($sku, $price);
        }

        $alias = $post->alias()->create(['alias' => $url]);

        return $alias;
    }
}
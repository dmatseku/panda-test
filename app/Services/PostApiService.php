<?php

namespace App\Services;

use App\Contracts\PostRepositoryInterface;
use App\Mail\PriceUpdatedEmail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class PostApiService
{
    public function __construct(
        protected PostRepositoryInterface $postRepository,
    )
    {

    }

    protected const OLX_API_OFFERS_URL = 'https://www.olx.ua/api/v2/offers/';

    public function extractSku($url)
    {
        $sku = false;

        if (preg_match('/^https:\/\/www\.olx\.ua\/api\/v2\/offers\/([a-z0-9]+)/i', trim($url), $matches)) {
            $sku = $matches[1];
        } else {
            $response = Http::get($url);

            if ($response->successful() && preg_match('/"\s*sku\s*"\s*:"([a-z0-9]+)"/i', $response->body(), $matches)) {
                $sku = $matches[1];
            }
        }

        return $sku;
    }

    public function getPostsPrice($sku)
    {
        $response = Http::get(static::OLX_API_OFFERS_URL . $sku);

        if ($response->successful()) {
            $params = $response->json('data.params');

            foreach ($params as $param) {
                if ($param['key'] === 'price' && isset($param['value']['value'])) {
                    return $param['value']['value'];
                }
            }
        }

        return false;
    }

    public function updatePostsInfo()
    {
        $postsCollection = $this->postRepository->all();
        $page = $postsCollection->forPage(1, 50);

        for ($pageNumber = 2; $page->count() > 0; $pageNumber++) {
            foreach ($page as $post) {
                try {
                    $price = $this->getPostsPrice($post->sku);

                    if (true || ($price !== false && (float)$price !== $post->price)) {
                        $url = $this->getPostAlias($post)->alias;

                        $this->notifySubscribers($post, $price, $url);
                        $post->price = $price;
                        $this->postRepository->save($post);
                    }
                } catch (\Throwable $e) {
                    //TODO: implement logging because this function must not fail
                }
            }

            $page = $postsCollection->forPage($pageNumber, 50);
        }
    }

    protected function getPostAlias($post)
    {
        if (!$post->alias || $post->alias->count() === 0) {
            throw new \Exception('Post structure is invalid');
        }

        return $post->alias->first();
    }

    protected function notifySubscribers($post, $newPrice, $url): void
    {
        $subscribersCollection = $post->subscribers;
        $page = $subscribersCollection->forPage(1, 50);

        for ($pageNumber = 2; $page->count() > 0; $pageNumber++) {
            foreach ($page as $subscriber) {
                if ($subscriber->confirmed) {
                    Mail::to($subscriber->email)->queue(new PriceUpdatedEmail((string)$newPrice, $post->price, $url));
                }
            }

            $page = $subscribersCollection->forPage($pageNumber, 50);
        }
    }
}
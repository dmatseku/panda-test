<?php

namespace App\Providers;

use App\Contracts\AliasRepositoryInterface;
use App\Contracts\PostRepositoryInterface;
use App\Contracts\SubscriberRepositoryInterface;
use App\Contracts\VerificationRepositoryInterface;
use App\Services\Repositories\AliasRepository;
use App\Services\Repositories\PostRepository;
use App\Services\Repositories\SubscriberRepository;
use App\Services\Repositories\VerificationRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->bind(SubscriberRepositoryInterface::class, SubscriberRepository::class);
        app()->bind(VerificationRepositoryInterface::class, VerificationRepository::class);
        app()->bind(AliasRepositoryInterface::class, AliasRepository::class);
        app()->bind(PostRepositoryInterface::class, PostRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

<?php

namespace App\Providers;

use App\Interfaces\DriverRepositoryInterface;
use App\Interfaces\NotificationRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
    }
}

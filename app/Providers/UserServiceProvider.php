<?php

namespace App\Providers;

use App\Services\User\Contracts\CreateUserDtoFactoryContract;
use App\Services\User\Contracts\UserRepositoryContract;
use App\Services\User\Contracts\UserServiceContract;
use App\Services\User\Factories\CreateUserDtoFactory;
use App\Services\User\Repositories\UserRepository;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CreateUserDtoFactoryContract::class, CreateUserDtoFactory::class);
        $this->app->singleton(UserRepositoryContract::class, UserRepository::class);
        $this->app->singleton(UserServiceContract::class, UserService::class);
    }
}

<?php

namespace App\Providers;

use App\Services\User\Contracts\CreateUserDtoFactoryContract;
use App\Services\User\Contracts\UpdateUserDtoFactoryContract;
use App\Services\User\Contracts\UpdateUserDtoFormatterContract;
use App\Services\User\Contracts\UserDtoFactoryContract;
use App\Services\User\Contracts\UserDtoFormatterContract;
use App\Services\User\Contracts\UserRepositoryContract;
use App\Services\User\Contracts\UserServiceContract;
use App\Services\User\Factories\CreateUserDtoFactory;
use App\Services\User\Factories\UpdateUserDtoFactory;
use App\Services\User\Factories\UserDtoFactory;
use App\Services\User\Formatters\UpdateUserDtoFormatter;
use App\Services\User\Formatters\UserDtoFormatter;
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
        $this->app->singleton(UserDtoFactoryContract::class, UserDtoFactory::class);
        $this->app->singleton(UserDtoFormatterContract::class, UserDtoFormatter::class);
        $this->app->singleton(UpdateUserDtoFactoryContract::class, UpdateUserDtoFactory::class);
        $this->app->singleton(UpdateUserDtoFormatterContract::class, UpdateUserDtoFormatter::class);
    }
}

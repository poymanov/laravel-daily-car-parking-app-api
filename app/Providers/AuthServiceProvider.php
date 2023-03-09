<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Services\Auth\AuthService;
use App\Services\Auth\Contracts\AuthDataDtoFactoryContract;
use App\Services\Auth\Contracts\AuthServiceContract;
use App\Services\Auth\Factories\AuthDataDtoFactory;
use App\Services\User\Contracts\UserServiceContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function register(): void
    {
        $tokenLifetimeInMinutes = (int)config('session.lifetime');

        $this->app->singleton(AuthServiceContract::class, fn () => new AuthService(
            $this->app->make(UserServiceContract::class),
            $tokenLifetimeInMinutes
        ));

        $this->app->singleton(AuthDataDtoFactoryContract::class, AuthDataDtoFactory::class);
    }

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}

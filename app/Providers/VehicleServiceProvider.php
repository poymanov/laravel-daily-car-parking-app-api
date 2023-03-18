<?php

namespace App\Providers;

use App\Services\Vehicle\Contracts\VehicleCacheKeysServiceContract;
use App\Services\Vehicle\Contracts\VehicleCacheServiceContract;
use App\Services\Vehicle\Contracts\VehicleCacheTagsServiceContract;
use App\Services\Vehicle\Contracts\VehicleDtoFactoryContract;
use App\Services\Vehicle\Contracts\VehicleDtoFormatterContract;
use App\Services\Vehicle\Contracts\VehicleRepositoryContract;
use App\Services\Vehicle\Contracts\VehicleServiceContract;
use App\Services\Vehicle\Contracts\VehicleUpdateDtoFactoryContract;
use App\Services\Vehicle\Contracts\VehicleUserServiceContract;
use App\Services\Vehicle\Factories\VehicleDtoFactory;
use App\Services\Vehicle\Factories\VehicleUpdateDtoFactory;
use App\Services\Vehicle\Formatters\VehicleDtoFormatter;
use App\Services\Vehicle\Repositories\VehicleRepository;
use App\Services\Vehicle\Services\VehicleCache\VehicleCacheKeysService;
use App\Services\Vehicle\Services\VehicleCache\VehicleCacheTagsService;
use App\Services\Vehicle\Services\VehicleCacheService;
use App\Services\Vehicle\Services\VehicleService;
use App\Services\Vehicle\Services\VehicleUserService;
use Illuminate\Cache\Repository;
use Illuminate\Support\ServiceProvider;

class VehicleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(VehicleDtoFactoryContract::class, VehicleDtoFactory::class);
        $this->app->singleton(VehicleDtoFormatterContract::class, VehicleDtoFormatter::class);
        $this->app->singleton(VehicleRepositoryContract::class, VehicleRepository::class);
        $this->app->singleton(VehicleServiceContract::class, VehicleService::class);
        $this->app->singleton(VehicleCacheTagsServiceContract::class, VehicleCacheTagsService::class);
        $this->app->singleton(VehicleCacheKeysServiceContract::class, VehicleCacheKeysService::class);
        $this->app->singleton(VehicleUpdateDtoFactoryContract::class, VehicleUpdateDtoFactory::class);
        $this->app->singleton(VehicleUserServiceContract::class, VehicleUserService::class);

        $this->app->singleton(VehicleCacheServiceContract::class, function () {
            return new VehicleCacheService(
                $this->app->make(Repository::class),
                $this->app->make(VehicleCacheTagsServiceContract::class),
                $this->app->make(VehicleCacheKeysServiceContract::class),
                (int)config('cache.ttl.vehicles')
            );
        });
    }
}

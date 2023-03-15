<?php

namespace App\Providers;

use App\Services\Vehicle\Contracts\VehicleCacheServiceContract;
use App\Services\Vehicle\Contracts\VehicleDtoFactoryContract;
use App\Services\Vehicle\Contracts\VehicleDtoFormatterContract;
use App\Services\Vehicle\Contracts\VehicleRepositoryContract;
use App\Services\Vehicle\Contracts\VehicleServiceContract;
use App\Services\Vehicle\Factories\VehicleDtoFactory;
use App\Services\Vehicle\Formatters\VehicleDtoFormatter;
use App\Services\Vehicle\Repositories\VehicleRepository;
use App\Services\Vehicle\Services\VehicleCacheService;
use App\Services\Vehicle\Services\VehicleService;
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

        $this->app->singleton(VehicleCacheServiceContract::class, function () {
            return new VehicleCacheService(
                $this->app->make(Repository::class),
                (int) config('cache.ttl.vehicles')
            );
        });
    }
}

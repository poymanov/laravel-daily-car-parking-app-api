<?php

namespace App\Providers;

use App\Services\Parking\Contracts\ParkingCacheKeysServiceContract;
use App\Services\Parking\Contracts\ParkingCacheServiceContract;
use App\Services\Parking\Contracts\ParkingCacheTagsServiceContract;
use App\Services\Parking\Contracts\ParkingDtoFactoryContract;
use App\Services\Parking\Contracts\ParkingDtoFormatterContract;
use App\Services\Parking\Contracts\ParkingRepositoryContract;
use App\Services\Parking\Contracts\ParkingServiceContract;
use App\Services\Parking\Contracts\ParkingStartDtoFactoryContract;
use App\Services\Parking\Contracts\ParkingUserServiceContract;
use App\Services\Parking\Factories\ParkingDtoFactory;
use App\Services\Parking\Factories\ParkingStartDtoFactory;
use App\Services\Parking\Formatters\ParkingDtoFormatter;
use App\Services\Parking\Repositories\ParkingRepository;
use App\Services\Parking\Services\ParkingCache\ParkingCacheKeysService;
use App\Services\Parking\Services\ParkingCache\ParkingCacheTagsService;
use App\Services\Parking\Services\ParkingCacheService;
use App\Services\Parking\Services\ParkingService;
use App\Services\Parking\Services\ParkingUserService;
use Illuminate\Cache\Repository;
use Illuminate\Support\ServiceProvider;

class ParkingServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ParkingStartDtoFactoryContract::class, ParkingStartDtoFactory::class);
        $this->app->singleton(ParkingServiceContract::class, ParkingService::class);
        $this->app->singleton(ParkingRepositoryContract::class, ParkingRepository::class);
        $this->app->singleton(ParkingDtoFactoryContract::class, ParkingDtoFactory::class);
        $this->app->singleton(ParkingDtoFormatterContract::class, ParkingDtoFormatter::class);
        $this->app->singleton(ParkingUserServiceContract::class, ParkingUserService::class);
        $this->app->singleton(ParkingCacheTagsServiceContract::class, ParkingCacheTagsService::class);
        $this->app->singleton(ParkingCacheKeysServiceContract::class, ParkingCacheKeysService::class);

        $this->app->singleton(ParkingCacheServiceContract::class, function () {
            return new ParkingCacheService(
                $this->app->make(Repository::class),
                $this->app->make(ParkingCacheTagsServiceContract::class),
                $this->app->make(ParkingCacheKeysServiceContract::class),
                (int)config('cache.ttl.parkings')
            );
        });
    }
}

<?php

namespace App\Providers;

use App\Services\Zone\Contracts\CreateZoneDtoFactoryContract;
use App\Services\Zone\Contracts\ZoneCacheServiceContract;
use App\Services\Zone\Contracts\ZoneCacheTagsServiceContract;
use App\Services\Zone\Contracts\ZoneRepositoryContract;
use App\Services\Zone\Contracts\ZoneServiceContract;
use App\Services\Zone\Factories\CreateZoneDtoFactory;
use App\Services\Zone\Repositories\ZoneRepository;
use App\Services\Zone\Services\ZoneCache\ZoneCacheTagsService;
use App\Services\Zone\Services\ZoneCacheService;
use App\Services\Zone\Services\ZoneService;
use Illuminate\Cache\Repository;
use Illuminate\Support\ServiceProvider;

class ZoneServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CreateZoneDtoFactoryContract::class, CreateZoneDtoFactory::class);
        $this->app->singleton(ZoneRepositoryContract::class, ZoneRepository::class);
        $this->app->singleton(ZoneServiceContract::class, ZoneService::class);
        $this->app->singleton(ZoneCacheTagsServiceContract::class, ZoneCacheTagsService::class);

        $this->app->singleton(ZoneCacheServiceContract::class, function () {
            return new ZoneCacheService(
                $this->app->make(Repository::class),
                $this->app->make(ZoneCacheTagsServiceContract::class)
            );
        });
    }
}

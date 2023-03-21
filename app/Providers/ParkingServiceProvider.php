<?php

namespace App\Providers;

use App\Services\Parking\Contracts\ParkingRepositoryContract;
use App\Services\Parking\Contracts\ParkingServiceContract;
use App\Services\Parking\Contracts\ParkingStartDtoFactoryContract;
use App\Services\Parking\Factories\ParkingStartDtoFactory;
use App\Services\Parking\Repositories\ParkingRepository;
use App\Services\Parking\Services\ParkingService;
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
    }
}

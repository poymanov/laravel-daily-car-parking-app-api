<?php

namespace App\Console\Commands\Parking;

use App\Services\Parking\Contracts\ParkingServiceContract;
use App\Jobs\Parking\CalculateTotalPrice as CalculateTotalPriceJob;
use Illuminate\Console\Command;
use Psy\Command\ExitCommand;

class CalculateTotalPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parking:calculate-total-price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate parking total price';

    public function __construct(private readonly ParkingServiceContract $parkingService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $activeParkings = $this->parkingService->findAllActive();

        foreach ($activeParkings as $activeParking) {
            CalculateTotalPriceJob::dispatch($activeParking->id);
        }

        return ExitCommand::SUCCESS;
    }
}

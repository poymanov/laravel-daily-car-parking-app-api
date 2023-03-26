<?php

namespace App\Jobs\Parking;

use App\Services\Parking\Contracts\ParkingCalculationServiceContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class CalculateTotalPrice implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private Uuid $parkingId;

    /**
     * Create a new job instance.
     */
    public function __construct(Uuid $parkingId)
    {
        $this->parkingId = $parkingId;
    }

    /**
     * Execute the job.
     */
    public function handle(ParkingCalculationServiceContract $parkingCalculationService): void
    {
        $parkingCalculationService->calculateTotalPrice($this->parkingId);
    }
}

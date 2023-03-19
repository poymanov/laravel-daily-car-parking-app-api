<?php

namespace App\Console\Commands\Zone;

use App\Services\Zone\Contracts\CreateZoneDtoFactoryContract;
use App\Services\Zone\Contracts\ZoneServiceContract;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Psy\Command\ExitCommand;
use Throwable;

class Create extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zone:create {name} {price_per_hour}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create parking zone';

    public function __construct(
        private readonly ZoneServiceContract $zoneService,
        private readonly CreateZoneDtoFactoryContract $createZoneDtoFactory
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $name         = $this->argument('name');
            $pricePerHour = (int)$this->argument('price_per_hour');

            if (!$name || !is_string($name)) {
                throw new InvalidArgumentException('Missing name argument');
            }

            if (!$pricePerHour) {
                throw new InvalidArgumentException('Missing price_per_hour argument');
            }

            $createZoneDto = $this->createZoneDtoFactory->createFromParams($name, $pricePerHour);

            $this->zoneService->create($createZoneDto);

            $this->info('Success');

            return ExitCommand::SUCCESS;
        } catch (Throwable $exception) {
            $exceptionMessage = $exception->getMessage();

            $this->error($exceptionMessage);
            Log::error($exceptionMessage);

            return ExitCommand::FAILURE;
        }
    }
}

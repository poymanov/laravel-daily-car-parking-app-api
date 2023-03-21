<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parking\StartRequest;
use App\Services\Parking\Contracts\ParkingServiceContract;
use App\Services\Parking\Contracts\ParkingStartDtoFactoryContract;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Throwable;

class ParkingController extends Controller
{
    public function __construct(
        private readonly ParkingStartDtoFactoryContract $parkingStartDtoFactory,
        private readonly ParkingServiceContract $parkingService
    ) {
    }

    /**
     * @param StartRequest $request
     *
     * @return Response
     * @throws Throwable
     * @throws \App\Services\Parking\Exceptions\StartParkingFailedException
     * @throws \App\Services\Parking\Exceptions\ParkingAlreadyStartedException
     * @throws \App\Services\Parking\Exceptions\VehicleNotBelongsToUserException
     * @throws \App\Services\Parking\Exceptions\ZoneNotExistsException
     */
    public function start(StartRequest $request): Response
    {
        try {
            $authUserId = $this->getAuthUserId($request);

            $parkingStartDto = $this->parkingStartDtoFactory->createFromParams(
                $request->get('vehicle_id'),
                $request->get('zone_id')
            );

            $this->parkingService->start($authUserId, $parkingStartDto);

            return response()->noContent();
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function stop(string $id): Response
    {
        try {
            $authUserId = $this->getAuthUserId(request());

            $parkingId = Uuid::make($id);

            $this->parkingService->stop($parkingId, $authUserId);

            return response()->noContent();
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}

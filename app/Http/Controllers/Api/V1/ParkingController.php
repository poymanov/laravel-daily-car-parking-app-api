<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parking\StartRequest;
use App\Services\Parking\Contracts\ParkingDtoFormatterContract;
use App\Services\Parking\Contracts\ParkingServiceContract;
use App\Services\Parking\Contracts\ParkingStartDtoFactoryContract;
use App\Services\Parking\Contracts\ParkingUserServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Throwable;

class ParkingController extends Controller
{
    public function __construct(
        private readonly ParkingStartDtoFactoryContract $parkingStartDtoFactory,
        private readonly ParkingServiceContract $parkingService,
        private readonly ParkingDtoFormatterContract $parkingDtoFormatter,
        private readonly ParkingUserServiceContract $parkingUserService
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

    /**
     * @param string $id
     *
     * @return Response
     * @throws Throwable
     * @throws \App\Services\Parking\Exceptions\ParkingAlreadyStoppedException
     * @throws \App\Services\Parking\Exceptions\ParkingNotBelongsToUserException
     * @throws \App\Services\Parking\Exceptions\ParkingNotFoundByIdException
     * @throws \App\Services\Parking\Exceptions\StopParkingFailedException
     */
    public function stop(string $id): Response
    {
        try {
            $authUserId = $this->getAuthUserId(request());

            $parkingId = Uuid::make($id);

            $this->parkingUserService->stop($parkingId, $authUserId);

            return response()->noContent();
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param string $id
     *
     * @return JsonResponse
     * @throws Throwable
     * @throws \App\Services\Parking\Exceptions\ParkingNotBelongsToUserException
     * @throws \App\Services\Parking\Exceptions\ParkingNotFoundByIdException
     */
    public function show(string $id): JsonResponse
    {
        try {
            $authUserId = $this->getAuthUserId(request());

            $parkingId = Uuid::make($id);

            $parking = $this->parkingUserService->getOneById($parkingId, $authUserId);

            $parkingFormatted = $this->parkingDtoFormatter->toArray($parking);

            return response()->json($parkingFormatted);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @return JsonResponse
     * @throws Throwable
     */
    public function active(): JsonResponse
    {
        try {
            $authUserId = $this->getAuthUserId(request());

            $parkings = $this->parkingService->findAllActiveByUserId($authUserId);

            $parkingsFormatted = $this->parkingDtoFormatter->fromArrayToArray($parkings);

            return response()->json($parkingsFormatted);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}

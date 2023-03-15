<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vehicle\StoreRequest;
use App\Services\Vehicle\Contracts\VehicleDtoFormatterContract;
use App\Services\Vehicle\Contracts\VehicleServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class VehicleController extends Controller
{
    public function __construct(
        private readonly VehicleServiceContract $vehicleService,
        private readonly VehicleDtoFormatterContract $vehicleDtoFormatter
    ) {
    }

    /**
     * @param StoreRequest $request
     *
     * @return JsonResponse
     * @throws Throwable
     * @throws \App\Services\Vehicle\Exceptions\CreateVehicleFailedException
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $authUserId = $this->getAuthUserId($request);

            $vehicle = $this->vehicleService->create($authUserId, $request->get('plate_number'));

            $vehicleFormatted = $this->vehicleDtoFormatter->toArray($vehicle);

            return response()->json($vehicleFormatted);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $authUserId = $this->getAuthUserId($request);

            $vehicles = $this->vehicleService->findAllByUserId($authUserId);

            $vehiclesFormatted = $this->vehicleDtoFormatter->fromArrayToArray($vehicles);

            return response()->json($vehiclesFormatted);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}

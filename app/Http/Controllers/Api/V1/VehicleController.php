<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vehicle\StoreRequest;
use App\Http\Requests\Vehicle\UpdateRequest;
use App\Services\Vehicle\Contracts\VehicleDtoFormatterContract;
use App\Services\Vehicle\Contracts\VehicleServiceContract;
use App\Services\Vehicle\Contracts\VehicleUpdateDtoFactoryContract;
use App\Services\Vehicle\Contracts\VehicleUserServiceContract;
use App\Services\Vehicle\Exceptions\UpdateVehicleFailedException;
use App\Services\Vehicle\Exceptions\VehicleNotBelongsToUserException;
use App\Services\Vehicle\Exceptions\VehicleNotFoundByIdException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class VehicleController extends Controller
{
    public function __construct(
        private readonly VehicleServiceContract $vehicleService,
        private readonly VehicleUserServiceContract $vehicleUserService,
        private readonly VehicleUpdateDtoFactoryContract $vehicleUpdateDtoFactory,
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

    /**
     * @param Request $request
     * @param string  $id
     *
     * @return JsonResponse
     * @throws Throwable
     * @throws VehicleNotBelongsToUserException
     * @throws VehicleNotFoundByIdException
     */
    public function show(Request $request, string $id): JsonResponse
    {
        try {
            $authUserId = $this->getAuthUserId($request);

            $vehicleId = Uuid::make($id);

            $vehicle = $this->vehicleUserService->getOneById($vehicleId, $authUserId);

            $vehicleFormatted = $this->vehicleDtoFormatter->toArray($vehicle);

            return response()->json($vehicleFormatted);
        } catch (VehicleNotFoundByIdException $e) {
            throw new NotFoundHttpException($e->getMessage());
        } catch (VehicleNotBelongsToUserException $e) {
            throw new AccessDeniedHttpException($e->getMessage());
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param UpdateRequest $request
     * @param string        $id
     *
     * @return JsonResponse
     * @throws Throwable
     * @throws VehicleNotBelongsToUserException
     * @throws VehicleNotFoundByIdException
     * @throws UpdateVehicleFailedException
     */
    public function update(UpdateRequest $request, string $id): JsonResponse
    {
        try {
            $authUserId = $this->getAuthUserId($request);

            $vehicleId = Uuid::make($id);

            $vehicleUpdateDto = $this->vehicleUpdateDtoFactory->createFromParam($request->get('plate_number'));

            $this->vehicleUserService->update($vehicleId, $authUserId, $vehicleUpdateDto);

            $vehicle = $this->vehicleUserService->getOneById($vehicleId, $authUserId);

            $vehicleFormatted = $this->vehicleDtoFormatter->toArray($vehicle);

            return response()->json($vehicleFormatted);
        } catch (VehicleNotFoundByIdException $e) {
            throw new NotFoundHttpException($e->getMessage());
        } catch (VehicleNotBelongsToUserException $e) {
            throw new AccessDeniedHttpException($e->getMessage());
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param Request $request
     * @param string  $id
     *
     * @return \Illuminate\Http\Response
     * @throws Throwable
     * @throws VehicleNotBelongsToUserException
     * @throws VehicleNotFoundByIdException
     * @throws \App\Services\Vehicle\Exceptions\DeleteVehicleFailedException
     */
    public function destroy(Request $request, string $id): Response
    {
        try {
            $authUserId = $this->getAuthUserId($request);

            $vehicleId = Uuid::make($id);

            $this->vehicleUserService->delete($vehicleId, $authUserId);

            return response()->noContent();
        } catch (VehicleNotFoundByIdException $e) {
            throw new NotFoundHttpException($e->getMessage());
        } catch (VehicleNotBelongsToUserException $e) {
            throw new AccessDeniedHttpException($e->getMessage());
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}

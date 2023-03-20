<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Zone\Contracts\ZoneDtoFormatterContract;
use App\Services\Zone\Contracts\ZoneServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class ZoneController extends Controller
{
    public function __construct(
        private readonly ZoneServiceContract $zoneService,
        private readonly ZoneDtoFormatterContract $zoneDtoFormatter
    ) {
    }

    public function index(): JsonResponse
    {
        try {
            $zones = $this->zoneService->findAll();

            $zonesFormatted = $this->zoneDtoFormatter->fromArrayToArray($zones);

            return response()->json($zonesFormatted);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}

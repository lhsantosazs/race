<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RaceRequest;
use Illuminate\Http\JsonResponse;
use App\Services\RaceService;

class RaceController extends Controller
{
    /**
     * Constructor to instantiate Request
     * @param RaceService $raceService
     */
    public function __construct(RaceService $raceService)
    {
        $this->raceService = $raceService;
    }

    /**
     * Create a race
     * @param RaceRequest $raceRequest
     * @return JsonResponse
     */
    public function create(RaceRequest $raceRequest) : JsonResponse
    {
        $params = $raceRequest->all();

        $raceCreated = $this->raceService->create($params);

        return response()->json($raceCreated);
    }
}

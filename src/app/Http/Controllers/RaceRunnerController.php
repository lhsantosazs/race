<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RaceRunnerRequest;
use App\Http\Requests\RaceRunnerResultsRequest;
use Illuminate\Http\JsonResponse;
use App\Services\RaceRunnerService;

class RaceRunnerController extends Controller
{
    /**
     * Constructor to instantiate Request
     * @param RaceRunnerService $raceRunnerService
     */
    public function __construct(RaceRunnerService $raceRunnerService)
    {
        $this->raceRunnerService = $raceRunnerService;
    }

    /**
     * Create a raceRunner
     * @param RaceRunnerRequest $raceRunnerRequest
     * @return JsonResponse
     */
    public function create(RaceRunnerRequest $raceRunnerRequest) : JsonResponse
    {
        $params = $raceRunnerRequest->all();

        $raceRunnerCreated = $this->raceRunnerService->create($params);

        return response()->json($raceRunnerCreated);
    }

    /**
     * Set runner results
     * @param RaceRunnerResultsRequest $raceRunnerResultsRequest
     * @return JsonResponse
     */
    public function setResults(RaceRunnerResultsRequest $raceRunnerResultsRequest) : JsonResponse
    {
        $params = $raceRunnerResultsRequest->all();

        $raceRunnerCreated = $this->raceRunnerService->setResults($params);

        return response()->json($raceRunnerCreated);
    }
}

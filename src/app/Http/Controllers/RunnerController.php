<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RunnerRequest;
use Illuminate\Http\JsonResponse;
use App\Services\RunnerService;

class RunnerController extends Controller
{
    /**
     * Constructor to instantiate Request
     * @param RunnerService $runnerService
     */
    public function __construct(RunnerService $runnerService)
    {
        $this->runnerService = $runnerService;
    }

    /**
     * Create a runner
     * @param RunnerRequest $runnerRequest
     * @return JsonResponse
     */
    public function create(RunnerRequest $runnerRequest) : JsonResponse
    {
        $params = $runnerRequest->all();

        $runnerCreated = $this->runnerService->create($params);

        return response()->json($runnerCreated);
    }
}

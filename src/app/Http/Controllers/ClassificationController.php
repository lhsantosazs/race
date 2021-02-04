<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\ClassificationService;

class ClassificationController extends Controller
{
    /**
     * Constructor to instantiate Request
     * @param ClassificationService $classificationService
     */
    public function __construct(ClassificationService $classificationService)
    {
        $this->classificationService = $classificationService;
    }

    /**
     * Get classification by age
     * @return JsonResponse
     */
    public function byAge() : JsonResponse
    {
        $classificationByAge = $this->classificationService->byAge();

        return response()->json($classificationByAge);
    }
}

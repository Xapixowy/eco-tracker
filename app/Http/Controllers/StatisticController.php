<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatisticRequest;
use App\Services\StatisticService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class StatisticController extends Controller
{
    private StatisticService $service;

    public function __construct(StatisticService $service)
    {
        $this->service = $service;
    }

    public function index(StatisticRequest $request): JsonResponse
    {
        $params = $request->only(StatisticRequest::FROM_KEY, StatisticRequest::TO_KEY);

        $response = [
            'message' => 'Statistics retrieved successfully',
            'data' => $this->service->index($params, $request->user()),
        ];

        if (isset($params[StatisticRequest::FROM_KEY])) {
            $response[StatisticRequest::FROM_KEY] = Carbon::make($params[StatisticRequest::FROM_KEY])->format('Y-m-d H:i:s');
        }

        if (isset($params[StatisticRequest::TO_KEY])) {
            $response[StatisticRequest::TO_KEY] = Carbon::make($params[StatisticRequest::TO_KEY])->format('Y-m-d H:i:s');
        }

        return response()->json($response);
    }
}

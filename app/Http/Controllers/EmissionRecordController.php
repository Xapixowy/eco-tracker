<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmissionRecordRequest;
use App\Services\EmissionRecordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmissionRecordController extends Controller
{
    private EmissionRecordService $service;

    public function __construct(EmissionRecordService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $source = $request->get('source');

        $emissionRecords = $this->service->index($source);

        return response()->json([
            'message' => 'Emission records retrieved successfully',
            'data' => $emissionRecords
        ]);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $source = $request->get('source');

        $emissionRecord = $this->service->show($id, $source);

        return response()->json([
            'message' => 'Emission record retrieved successfully',
            'data' => $emissionRecord
        ]);
    }

    public function store(EmissionRecordRequest $request, int $id): JsonResponse
    {
        $source = $request->get('source');

        $emissionRecord = $this->service->store($request->all(), $source);

        return response()->json([
            'message' => 'Emission record retrieved successfully',
            'data' => $emissionRecord
        ]);
    }


    public function destroy(Request $request, int $id): JsonResponse
    {
        $source = $request->get('source');

        $this->service->destroy($id, $source);

        return response()->json([
            'message' => 'Vehicle deleted successfully',
        ]);
    }
}

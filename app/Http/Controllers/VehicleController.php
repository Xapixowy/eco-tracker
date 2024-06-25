<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleRequest;
use App\Services\VehicleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    private VehicleService $service;

    public function __construct(VehicleService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $vehicles = $this->service->index($request->user());

        return response()->json([
            'message' => 'Vehicles retrieved successfully',
            'data' => $vehicles
        ]);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $vehicle = $this->service->show($id, $request->user());

        return response()->json([
            'message' => 'Vehicle retrieved successfully',
            'data' => $vehicle
        ]);
    }

    public function store(VehicleRequest $request): JsonResponse
    {
        $vehicle = $this->service->store($request->all(), $request->user());

        return response()->json([
            'message' => 'Vehicle stored successfully',
            'data' => $vehicle
        ], 201);
    }

    public function update(VehicleRequest $request, int $id): JsonResponse
    {
        $vehicle = $this->service->update($id, $request->all(), $request->user());

        return response()->json([
            'message' => 'Vehicle updated successfully',
            'data' => $vehicle
        ]);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->service->destroy($id, $request->user());

        return response()->json([
            'message' => 'Vehicle deleted successfully',
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeRequest;
use App\Services\HomeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private HomeService $service;

    public function __construct(HomeService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'Homes retrieved successfully',
            'data' => $this->service->index($request->user())
        ]);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        return response()->json([
            'message' => 'Home retrieved successfully',
            'data' => $this->service->show($id, $request->user())
        ]);
    }

    public function store(HomeRequest $request): JsonResponse
    {
        return response()->json([
            'message' => 'Home stored successfully',
            'data' => $this->service->store($request->all(), $request->user())
        ], 201);
    }

    public function update(HomeRequest $request, int $id): JsonResponse
    {
        return response()->json([
            'message' => 'Home updated successfully',
            'data' => $this->service->update($id, $request->all(), $request->user())
        ]);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->service->destroy($id, $request->user());

        return response()->json([
            'message' => 'Home deleted successfully',
        ]);
    }
}

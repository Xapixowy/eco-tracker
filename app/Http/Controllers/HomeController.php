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
        $homes = $this->service->index($request->user());

        return response()->json([
            'message' => 'Homes retrieved successfully',
            'data' => $homes
        ]);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $home = $this->service->show($id, $request->user());

        return response()->json([
            'message' => 'Home retrieved successfully',
            'data' => $home
        ]);
    }

    public function store(HomeRequest $request): JsonResponse
    {
        $home = $this->service->store($request->all(), $request->user());

        return response()->json([
            'message' => 'Home stored successfully',
            'data' => $home
        ], 201);
    }

    public function update(HomeRequest $request, int $id): JsonResponse
    {
        $home = $this->service->update($id, $request->all(), $request->user());

        return response()->json([
            'message' => 'Home updated successfully',
            'data' => $home
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

<?php

namespace App\Services;

use App\Exceptions\VehicleNotFoundException;
use App\Http\Resources\VehicleResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class VehicleService
{
    public function index(User $user): AnonymousResourceCollection
    {
        return VehicleResource::collection($user->vehicles);
    }

    public function show(int $id, User $user): VehicleResource
    {
        $vehicle = $user->vehicles()->find($id);

        if (!$vehicle) {
            throw new VehicleNotFoundException();
        }

        return VehicleResource::make($vehicle);
    }

    public function store(array $data, User $user): VehicleResource
    {
        return DB::transaction(function () use ($data, $user) {
            return VehicleResource::make($user->vehicles()->create($data));
        });
    }

    public function update(int $id, array $data, User $user): VehicleResource
    {
        $vehicle = $user->vehicles()->find($id);

        if (!$vehicle) {
            throw new VehicleNotFoundException();
        }

        return DB::transaction(function () use ($data, $vehicle) {
            $vehicle->update($data);

            return VehicleResource::make($vehicle);
        });
    }

    public function destroy(int $id, User $user): void
    {
        $vehicle = $user->vehicles()->find($id);

        if (!$vehicle) {
            throw new VehicleNotFoundException();
        }

        DB::transaction(function () use ($vehicle) {
            $vehicle->delete();
        });
    }
}

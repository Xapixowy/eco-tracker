<?php

namespace App\Services;

use App\Exceptions\HomeNotFoundException;
use App\Http\Requests\HomeRequest;
use App\Http\Resources\HomeResource;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class HomeService
{
    public function index(User $user): AnonymousResourceCollection
    {
        return HomeResource::collection($user->homes);
    }

    public function show(int $id, User $user): HomeResource
    {
        $home = $user->homes()->find($id);

        if (!$home) {
            throw new HomeNotFoundException();
        }

        return HomeResource::make($home);
    }

    public function store(array $data, User $user): HomeResource
    {
        return DB::transaction(function () use ($data, $user) {
            $address = Address::create([
                'street' => $data[HomeRequest::ADDRESS_STREET_KEY],
                'building' => $data[HomeRequest::ADDRESS_BUILDING_KEY],
                'apartment' => $data[HomeRequest::ADDRESS_APARTMENT_KEY] ?? null,
                'zip_code' => $data[HomeRequest::ADDRESS_ZIP_CODE_KEY],
                'city' => $data[HomeRequest::ADDRESS_CITY_KEY],
                'voivodeship' => $data[HomeRequest::ADDRESS_VOIVODESHIP_KEY],
            ]);

            return HomeResource::make($user->homes()->create([
                'address_id' => $address->id,
            ]));
        });
    }

    public function update(int $id, array $data, User $user): HomeResource
    {
        $home = $user->homes()->find($id);

        $addressData = array_filter([
            'street' => $data[HomeRequest::ADDRESS_STREET_KEY] ?? null,
            'building' => $data[HomeRequest::ADDRESS_BUILDING_KEY] ?? null,
            'apartment' => $data[HomeRequest::ADDRESS_APARTMENT_KEY] ?? null,
            'zip_code' => $data[HomeRequest::ADDRESS_ZIP_CODE_KEY] ?? null,
            'city' => $data[HomeRequest::ADDRESS_CITY_KEY] ?? null,
            'voivodeship' => $data[HomeRequest::ADDRESS_VOIVODESHIP_KEY] ?? null,
        ], fn($value) => $value !== null);

        if (!$home) {
            throw new HomeNotFoundException();
        }

        return DB::transaction(function () use ($addressData, $home) {
            $home->address()->update($addressData);

            return HomeResource::make($home);
        });
    }

    public function destroy(int $id, User $user): void
    {
        $home = $user->homes()->find($id);

        if (!$home) {
            throw new HomeNotFoundException();
        }

        DB::transaction(function () use ($home) {
            $home->address()->delete();
            $home->delete();
        });
    }
}

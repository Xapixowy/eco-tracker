<?php

namespace App\Services;

use App\Enums\FuelTypeEnum;
use App\Exceptions\EmissionRecordNotFoundException;
use App\Exceptions\VehicleNotFoundException;
use App\Http\Resources\EmissionRecordResource;
use App\Models\FuelType;
use App\Models\Home;
use App\Models\Vehicle;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class EmissionRecordService
{
    public function index(Vehicle|Home $source): AnonymousResourceCollection
    {
        return EmissionRecordResource::collection($source->emissionRecords);
    }

    public function show(int $id, Vehicle|Home $source): EmissionRecordResource
    {
        $emissionRecord = $source->emissionRecords()->find($id);

        if (!$emissionRecord) {
            throw new EmissionRecordNotFoundException();
        }

        return EmissionRecordResource::make($emissionRecord);
    }

    public function store(array $data, Vehicle|Home $source): EmissionRecordResource
    {
        return DB::transaction(function () use ($data, $source) {
            return EmissionRecordResource::make($source->emissionRecords()->create([
                ...$data,
                'co2_emmision' => $this->calculateCo2Emission($data['fuel_type_id'], $data['fuel_consumption']),
            ]));
        });
    }

    public function destroy(int $id, Vehicle|Home $source): void
    {
        $emissionRecord = $source->emissionRecords()->find($id);

        if (!$emissionRecord) {
            throw new VehicleNotFoundException();
        }

        DB::transaction(function () use ($emissionRecord) {
            $emissionRecord->delete();
        });
    }

    private function calculateCo2Emission(int $fuelTypeId, float $fuelConsumption): float
    {
        $fuelType = FuelType::find($fuelTypeId);

        if (!$fuelType) {
            throw new EmissionRecordNotFoundException();
        }

        switch (FuelTypeEnum::from($fuelType->name)) {
            case FuelTypeEnum::DIESEL:
                return round($fuelConsumption * Config::get('co2.diesel_co2_emission_per_litre'), 2);
            case FuelTypeEnum::GASOLINE:
                return round($fuelConsumption * Config::get('co2.gasoline_co2_emission_per_litre'), 2);
            case FuelTypeEnum::ELECTRICITY:
                return round($fuelConsumption * Config::get('co2.electricity_co2_emission_per_kwh'), 2);
            case FuelTypeEnum::NATURAL_GAS:
                return round($fuelConsumption * Config::get('co2.natural_gas_co2_emission_per_m3'), 2);
            default:
                throw new EmissionRecordNotFoundException();
        }
    }
}

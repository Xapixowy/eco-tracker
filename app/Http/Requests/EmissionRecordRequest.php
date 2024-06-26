<?php

namespace App\Http\Requests;

use App\Models\FuelType;
use Illuminate\Foundation\Http\FormRequest;

class EmissionRecordRequest extends FormRequest
{
    const VEHICLE_STORE_ROUTE = 'vehicles.emission-records.store';
    const HOMES_STORE_ROUTE = 'homes.emission-records.store';
    const FUEL_TYPE_ID_KEY = 'fuel_type_id';
    const FUEL_CONSUMPTION_KEY = 'fuel_consumption';
    const START_AT_KEY = 'start_at';
    const END_AT_KEY = 'end_at';

    private static $rules = [
        self::VEHICLE_STORE_ROUTE => [
            self::FUEL_CONSUMPTION_KEY => 'required|numeric',
            self::START_AT_KEY => 'required|date',
            self::END_AT_KEY => 'required|date',
        ],
        self::HOMES_STORE_ROUTE => [
            self::FUEL_TYPE_ID_KEY => [
                'required',
                'integer',
            ],
            self::FUEL_CONSUMPTION_KEY => 'required|numeric',
            self::START_AT_KEY => 'required|date',
            self::END_AT_KEY => 'required|date',
        ]
    ];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        $fuelTypeIdMessage = $this->getFuelTypeIdMessage();

        return $fuelTypeIdMessage ? [self::FUEL_TYPE_ID_KEY => $fuelTypeIdMessage] : [];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = self::$rules[$this->route()->getName()];

        $fuelTypeIdRules = $this->getFuelTypeIdRules();

        if ($fuelTypeIdRules) {
            $rules[self::FUEL_TYPE_ID_KEY] = $fuelTypeIdRules;
        }

        return $rules;
    }

    private function getFuelTypeIdMessage(): string|null
    {
        if ($this->route()->getName() === self::HOMES_STORE_ROUTE) {
            $availableFuelTypeNames = ['Electricity', 'Natural Gas'];

            $availableFuelTypes = FuelType::pluck('name', 'id')
                ->filter(function ($item) use ($availableFuelTypeNames) {
                    return in_array($item, $availableFuelTypeNames);
                })
                ->map(function ($item, $key) {
                    return $key . ' => ' . $item;
                })->toArray();;

            return 'The selected fuel type id is invalid. Available fuel types: ' . implode(', ', $availableFuelTypes);
        }

        return null;
    }

    private function getFuelTypeIdRules(): array|null
    {
        if ($this->route()->getName() === self::HOMES_STORE_ROUTE) {
            $availableFuelTypeNames = ['Electricity', 'Natural Gas'];

            $availableFuelTypeIds = FuelType::pluck('name', 'id')
                ->filter(function ($item) use ($availableFuelTypeNames) {
                    return in_array($item, $availableFuelTypeNames);
                })
                ->keys()
                ->toArray();

            return ['required', 'integer', 'exists:fuel_types,id', 'in:' . implode(',', $availableFuelTypeIds)];
        }

        return null;
    }
}

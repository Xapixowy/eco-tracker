<?php

namespace App\Http\Requests;

use App\Models\FuelType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class EmissionRecordRequest extends FormRequest
{
    const STORE_ROUTE = 'emission-records.store';
    const FUEL_TYPE_ID_KEY = 'fuel_type_id';
    const FUEL_CONSUMPTION_KEY = 'fuel_consumption';
    const START_AT_KEY = 'start_at';
    const END_AT_KEY = 'end_at';

    private static $rules = [
        self::STORE_ROUTE => [
            self::FUEL_TYPE_ID_KEY => 'required|integer|exists:fuel_types,id',
            self::FUEL_CONSUMPTION_KEY => 'required|numeric',
            self::START_AT_KEY => 'required|date',
            self::END_AT_KEY => 'required|date',
        ],
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
        $vehicleAvailableFuelTypesCollection = FuelType::pluck('name', 'id')
            ->filter(function ($item) {
                return $item == 'Diesel' || $item == 'Gasoline';
            });

        $homeAvailableFuelTypesCollection = FuelType::pluck('name', 'id')
            ->filter(function ($item) {
                return $item == 'Electricity' || $item == 'Natural Gas';
            });

        if ($this->request->get('sourceType') == 'vehicles') {
            $availableFuelTypesCollection = $vehicleAvailableFuelTypesCollection;
        } else {
            $availableFuelTypesCollection = $homeAvailableFuelTypesCollection;
        }

        $availableFuelTypes = $availableFuelTypesCollection->map(function ($item, $key) {
            return $key . ' => ' . $item;
        })->toArray();

        return [
            self::FUEL_TYPE_ID_KEY => 'The selected fuel type id is invalid. Available fuel types: ' . implode(', ', $availableFuelTypes),
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return self::$rules[Str::after($this->route()->getName(), '.')];
    }
}

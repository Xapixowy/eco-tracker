<?php

namespace App\Http\Requests;

use App\Models\FuelType;
use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
{
    const STORE_ROUTE = 'vehicles.store';
    const UPDATE_ROUTE = 'vehicles.update';
    const NAME_KEY = 'name';
    const FUEL_TYPE_ID_KEY = 'fuel_type_id';

    private static $rules = [
        self::STORE_ROUTE => [
            self::NAME_KEY => 'required|string|max:255',
            self::FUEL_TYPE_ID_KEY => 'required|integer|exists:fuel_types,id',
        ],
        self::UPDATE_ROUTE => [
            self::NAME_KEY => 'string|max:255',
            self::FUEL_TYPE_ID_KEY => 'integer|exists:fuel_types,id',
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
        $availableFuelTypes = FuelType::pluck('name', 'id')->map(function ($item, $key) {
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
        return self::$rules[$this->route()->getName()];
    }
}

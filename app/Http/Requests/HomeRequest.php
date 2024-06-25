<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeRequest extends FormRequest
{
    const STORE_ROUTE = 'homes.store';
    const UPDATE_ROUTE = 'homes.update';
    const ADDRESS_STREET_KEY = 'address_street';
    const ADDRESS_BUILDING_KEY = 'address_building';
    const ADDRESS_APARTMENT_KEY = 'address_apartment';
    const ADDRESS_ZIP_CODE_KEY = 'address_zip_code';
    const ADDRESS_CITY_KEY = 'address_city';
    const ADDRESS_VOIVODESHIP_KEY = 'address_voivodeship';

    private static $rules = [
        self::STORE_ROUTE => [
            self::ADDRESS_STREET_KEY => 'required|string|max:255',
            self::ADDRESS_BUILDING_KEY => 'required|string|max:255',
            self::ADDRESS_APARTMENT_KEY => 'string|max:255',
            self::ADDRESS_ZIP_CODE_KEY => 'required|string|max:255',
            self::ADDRESS_CITY_KEY => 'required|string|max:255',
            self::ADDRESS_VOIVODESHIP_KEY => 'required|string|max:255',
        ],
        self::UPDATE_ROUTE => [
            self::ADDRESS_STREET_KEY => 'string|max:255',
            self::ADDRESS_BUILDING_KEY => 'string|max:255',
            self::ADDRESS_APARTMENT_KEY => 'string|max:255',
            self::ADDRESS_ZIP_CODE_KEY => 'string|max:255',
            self::ADDRESS_CITY_KEY => 'string|max:255',
            self::ADDRESS_VOIVODESHIP_KEY => 'string|max:255',
        ]
    ];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatisticRequest extends FormRequest
{
    const INDEX_ROUTE = 'statistics.index';
    const FROM_KEY = 'from';
    const TO_KEY = 'to';

    private static $rules = [
        self::INDEX_ROUTE => [
            self::FROM_KEY => [
                'sometimes',
                'required',
                'date',
            ],
            self::TO_KEY => [
                'sometimes',
                'required',
                'date',
            ]
        ],
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
        $rules = self::$rules[$this->route()->getName()];

        if (isset($rules[self::FROM_KEY]) && isset($rules[self::TO_KEY])) {
            $rules[self::FROM_KEY][] = 'before_or_equal:to';
            $rules[self::TO_KEY][] = 'after_or_equal:from';
        }

        return self::$rules[$this->route()->getName()];
    }
}

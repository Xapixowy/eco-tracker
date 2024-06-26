<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    const REGISTER_ROUTE = 'auth.register';
    const LOGIN_ROUTE = 'auth.login';
    const USERNAME_KEY = 'username';
    const EMAIL_KEY = 'email';
    const PASSWORD_KEY = 'password';

    private static $rules = [
        self::REGISTER_ROUTE => [
            self::USERNAME_KEY => 'required|string|max:255',
            self::EMAIL_KEY => 'required|string|email|max:255|unique:users',
            self::PASSWORD_KEY => 'required|string|min:8|confirmed'
        ],
        self::LOGIN_ROUTE => [
            self::EMAIL_KEY => 'required|string|email',
            self::PASSWORD_KEY => 'required|string',
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
        return self::$rules[$this->route()->getName()];
    }
}

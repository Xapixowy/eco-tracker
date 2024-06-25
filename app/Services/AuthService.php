<?php

namespace App\Services;

use App\Exceptions\UserAlreadyLoggedInException;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\UserNotLoggedInException;
use App\Exceptions\UserPasswordIncorrectException;
use App\Http\Resources\UserResource;
use App\Models\SourceType;
use App\Models\Statistic;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $data): UserResource
    {
        return DB::transaction(function () use ($data) {
            $newUser = User::create([
                ...$data,
                'password' => Hash::make($data['password']),
            ]);
            Statistic::create([
                'user_id' => $newUser->id,
                'source_type_id' => SourceType::where('name', 'Vehicle')->first()->id,
            ]);
            Statistic::create([
                'user_id' => $newUser->id,
                'source_type_id' => SourceType::where('name', 'Home')->first()->id,
            ]);

            return UserResource::make($newUser);
        });
    }

    public function login(array $data): string
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            throw new UserNotFoundException();
        }

        if (!Hash::check($data['password'], $user->password)) {
            throw new UserPasswordIncorrectException();
        }

        if ($user->tokens()->count() > 0) {
            $user->tokens()->delete();
        }
        return $user->createToken('token')->plainTextToken;
    }

    public function logout(User $user): void
    {
        if ($user->tokens()->get()->count() === 0) {
            throw new UserNotLoggedInException();
        }

        $user->tokens()->delete();
    }
}

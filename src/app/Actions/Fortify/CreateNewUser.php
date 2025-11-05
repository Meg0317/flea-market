<?php

namespace App\Actions\Fortify;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    public function create(array $input): User
    {
        // RegisterRequest を使ってバリデーション
        $request = app(RegisterRequest::class);
        $request->merge($input);   // $input を注入
        $validated = $request->validated();

        return User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
    }
}


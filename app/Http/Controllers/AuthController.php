<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {

        $credentials = $request->getCredentials();

        if(! Auth::validate($credentials)) {
            return response([
                'error' => true,
                'message' => 'Invalid credentials'
            ]);
        }

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        $userRoles = $user->roles()->pluck('slug')->all();

        $token = $user->createToken('access-token', $userRoles)->plainTextToken;

        $response = [
            'user' => $user,
            'roles' => $userRoles,
            'token' => $token
        ];

        return response($response);
    }

    public function register(Request $request)
    {
        $payload = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'min:11', 'max:12', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'username'  => $payload['username'],
            'email'     => $payload['email'],
            'phone'     => $payload['phone'],
            'password'  => $payload['password'],
        ]);

        $user->roles()->attach(Role::where('slug', 'user')->first());

        $tokenRoles = Role::where('slug', 'user')->get()->pluck('slug')->all();

        $token = $user->createToken('access-token', $tokenRoles)->plainTextToken;

        $response = [
            'user' => $user,
            'roles' => $tokenRoles,
            'token' => $token
        ];

        return response($response, 201);
    }
}

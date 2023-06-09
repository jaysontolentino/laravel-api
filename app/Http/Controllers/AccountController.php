<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    // revoking tokens
    public function revokeTokens(Request $request)
    {
        $request->user()->tokens()->delete();

        return response([
            'message' => 'All tokens has been revoked.'
        ]);
    }

    public function me(Request $request) {

        $user = $request->user();
        $roles = $request->user()->roles()->pluck('slug')->all();
        $token = $request->bearerToken();

        return response([
            'user' => $user,
            'roles' => $roles,
            'token' => $token
        ]);
    }
}

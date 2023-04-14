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

    public function profile() {
        
    }
}

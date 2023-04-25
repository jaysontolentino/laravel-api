<?php

namespace App\Http\Controllers;

use App\Models\Role;

use Illuminate\Http\Request;

class RoleController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $roles = Role::all();

        return response()->json($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return response($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return response($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        // update an user
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $user->delete();

        return response()->noContent();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Http\Filters\UsersFilter;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class UserController extends Controller
{

    public function __construct()
    {
        //$this->middleware([])
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $users = QueryBuilder::for(User::class)
            ->allowedIncludes(['roles'])
            ->allowedFilters([
                AllowedFilter::custom('all', new UsersFilter)
            ])
            ->allowedSorts(['id', 'created_at', 'username', 'email', 'phone'])
            ->paginate($request->get('rowsPerPage', 10));

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        
        $user = User::create([
            'username'  => $request['username'],
            'email'     => $request['email'],
            'phone'     => $request['phone'],
            'password'  => $request['password'],
        ]);

        $user->roles()->attach(Role::where('slug', $request['role'])->first());

        $response = [
            'success' => true,
            'user' => $user,
            'message' => 'User created'
        ];

        return response($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {   
        $roles = $user->roles()->pluck('slug')->all();

        $response = [
            'user' => $user,
            'role' => $roles
        ];

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->phone = $request['phone'];

        $currentRoles = $user->roles;

        $user->roles()->detach($currentRoles[0]->id);

        $user->roles()->attach(Role::where('slug', $request['role'])->first());

        $user->save();

        return response()->json($user);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }
}

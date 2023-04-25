<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Filters\UsersFilter;

use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        $payload = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'min:11', 'max:12', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            'password' => ['required', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,user'],
        ]);

        $user = User::create([
            'username'  => $payload['username'],
            'email'     => $payload['email'],
            'phone'     => $payload['phone'],
            'password'  => $payload['password'],
        ]);

        $user->roles()->attach(Role::where('slug', $payload['role'])->first());

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
        return response($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // update an user
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

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'username' => 'admin',
            'email' => 'admin@email.com',
            'phone' => '09123456789',
            'password' => 'admin1234'
        ]);

        $adminRoles = Role::where('slug', 'admin')->first();

        $user->roles()->attach($adminRoles);
    }
}

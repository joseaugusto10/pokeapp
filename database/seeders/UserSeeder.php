<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@pokeapp.com',
            'password' => Hash::make('123456'),
        ]);

        $editor = User::create([
            'name' => 'Editor',
            'email' => 'editor@pokeapp.com',
            'password' => Hash::make('123456'),
        ]);

        $viewer = User::create([
            'name' => 'Viewer',
            'email' => 'viewer@pokeapp.com',
            'password' => Hash::make('123456'),
        ]);

        $admin->roles()->attach(Role::where('name', 'admin')->first());
        $editor->roles()->attach(Role::where('name', 'editor')->first());
        $viewer->roles()->attach(Role::where('name', 'viewer')->first());
    }
}

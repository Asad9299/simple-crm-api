<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'uuid'      => Str::uuid(),
            'name'      => 'Admin',
            'email'     => 'admin@gmail.com',
            'password'  => 'Admin@123'
        ]);

        $admin->assignRole('admin');
    }
}

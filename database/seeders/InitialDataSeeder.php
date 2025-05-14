<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create admin user
        User::create([
            'name' => 'Admin',
            'email' => env('ADMIN_EMAIL', 'superadmin@crispygo.store'),
            'password' => bcrypt(env('ADMIN_PASSWORD', 'password')),
            'email_verified_at' => Carbon::now()
        ]);
    }
}

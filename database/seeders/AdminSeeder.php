<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutEvents;

class AdminSeeder extends Seeder
{
    use WithoutEvents;

    public function run(): void
    {
        $userData = [
            'first_name' => 'petify',
            'last_name' => 'ninja',
            'username' => 'petify-ninja',
            'email' => 'ninja@petify.com',
            'password' => Hash::make('Ninja@008'),
            'contact_no' => '03138912762',
            'email_verified_at' => Carbon::now(),
        ];
        
        $user = User::create($userData);

        $user->assignRole('admin');
    }
}

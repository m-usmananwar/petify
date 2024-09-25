<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $userData = [
            'first_name' => 'petify',
            'last_name' => 'ninja',
            'username' => 'petify-ninja',
            'email' => 'ninja@petify.com',
            'password' => 'Ninja@008',
            'contact_no' => '03138912762',
            'email_verified_at' => Carbon::now(),
        ];
        
        $user = User::create($userData);

        $user->assignRole('admin');
    }
}

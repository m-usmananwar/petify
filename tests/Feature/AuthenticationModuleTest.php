<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationModuleTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $unVerifiedUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
        $this->unVerifiedUser = $this->createUser(false);
    }

    public function test_user_can_login()
    {
        $response = $this->postJson('/api/signin', [
            'email' => $this->user->email,
            'password' => 'Ninja@008',
        ]);

        $response->assertStatus(200);
        $this->assertNotNull($response->json('token'));
    }

    public function test_unverified_user_cannot_login()
    {
        $response = $this->postJson('/api/signin', [
            'email' => $this->unVerifiedUser->email,
            'password' => 'Ninja@008',
        ]);

        $response->assertStatus(403);
    }

    public function test_non_existing_user_cannot_login()
    {
        $response = $this->postJson('/api/signin', [
            'email' => 'non-existing@gmail.com',
            'password' => 'Ninja@008',
        ]);

        $response->assertStatus(422);
    }

    private function createUser($verified = true): User
    {
        return User::create([
            'first_name' => 'petify',
            'last_name' => 'ninja',
            'username' => 'petify-ninja',
            'contact_no' => '+923138912762',
            'email' => $verified ? 'ninja@example.com' : 'ninja@unverified.com',
            'password' => Hash::make('Ninja@008'),
            'email_verified_at' => $verified ? Carbon::now() : null,
        ]);
    }
}

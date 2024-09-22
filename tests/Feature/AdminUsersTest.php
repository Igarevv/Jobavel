<?php

namespace Tests\Feature;

use App\Persistence\Models\User;
use Database\Factories\Persistence\Models\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUsersTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleted_users_cannot_login_to_account(): void
    {
        $this->withoutMiddleware();

        $user = User::factory()->state(['deleted_at' => now()])->create();

        $response = $this->post('/auth/login', [
            'email' => $user->email,
            'password' => UserFactory::TEST_PASSWORD
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Wrong email or password. Please try again'
        ]);
    }


}

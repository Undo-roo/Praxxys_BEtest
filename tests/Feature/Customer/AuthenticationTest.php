<?php

namespace Tests\Feature\Customer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /** @test */
    public function customer_auth_username_password_is_required(): void
    {
        $this->get('/login')->assertStatus(200);

        $this->post('/attempt', [ 
            "username" => '',
            "password" => '',
            "remember" => '',
        ])->assertSessionHasErrors(['username', 'password']);
    }

    /** @test */
    public function customer_auth_invalid_credentials(): void
    {
        $user = User::factory()->create();

        $this->post('/attempt', [ 
            "username" => 'Dummy',
            "password" => 'Dummy123',
        ])->assertSessionHasErrors('username');

    }
}

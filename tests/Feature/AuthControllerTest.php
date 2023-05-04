<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\UserHelper;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use UserHelper, RefreshDatabase, DatabaseMigrations;

    public function test_user_can_login_with_valid_credencials(): void
    {
        $this->createUser();
        $credencials = $this->getCredencialsValid();

        $response = $this->postJson('/api/auth', $credencials);
        $response->assertStatus(201);
    }

    public function test_user_cant_login_with_valid_credencials_when_user_is_deleted(): void
    {
        $this->createUser();
        $this->user->delete();
        $credencials = $this->getCredencialsValid();

        $response = $this->postJson('/api/auth', $credencials);
        $response->assertStatus(401);
    }

    public function test_user_cant_login_with_invalid_credencials(): void
    {
        $this->createUser();
        $credencials = $this->getCredencialsInvalid();

        $response = $this->postJson('/api/auth', $credencials);
        $response->assertStatus(401);
    }

    public function test_user_cant_login_without_email(): void
    {
        $this->createUser();
        $credencials = $this->getCredencialsWithoutEmail();

        $response = $this->postJson('/api/auth', $credencials);
        $response->assertStatus(422);
    }


    public function test_user_cant_login_without_password(): void
    {
        $this->createUser();
        $credencials = $this->getCredencialsWithoutPassword();

        $response = $this->postJson('/api/auth', $credencials);
        $response->assertStatus(422);
    }

    public function test_user_cant_login_with_invalid_email(): void
    {
        $this->createUser();
        $credencials = $this->getCredencialsWithInvalidEmail();

        $response = $this->postJson('/api/auth', $credencials);
        $response->assertStatus(422);
    }

    public function test_user_can_show_own_data_when_login(): void
    {
        $this->createUser();

        $response = $this->actingas($this->user)->getJson('/api/auth');
//        $response = $this->getJson('/api/auth');
        $response
            ->assertStatus(200)
            ->assertJson(
                [
                    'name' => $this->user->name,
                    'email' => $this->user->email
                ]
            );
        }

        public function test_user_cant_show_own_data_when_not_login(): void
        {
            $response = $this->getJson('/api/auth');
            $response->assertStatus(401);
        }

        public function test_user_can_logout_when_is_login(): void
        {
            $this->createUser();
            $response = $this->actingas($this->user)->deleteJson('/api/auth');
            $response->assertStatus(200);
            print_r($response->json());
    }

    public function test_user_cant_logout_when_not_login(): void
    {
        $response = $this->deleteJson('/api/auth');
        $response->assertStatus(401);
    }

}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserController extends TestCase
{
    use RefreshDatabase;

    private $apiUrl = "http://roslina-b.poligon/api/";

    public function test_StoreUser_WithInvalidData()
    {
        $user = User::factory()->make()->toArray();
        $user['name'] = '';
        $user['email'] = '';
        $user['password'] = '';
        $user['password_confirmation'] = '';

        $this->postJson($this->apiUrl . 'users', $user)
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email',
                    'name',
                    'password',
                ]
            ]);
    }

    public function test_StoreUser_WithoutData()
    {
        $this->postJson($this->apiUrl . 'users')
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email',
                    'name',
                    'password',
                ]
            ]);
    }

    public function test_StoreUser_WithOKData()
    {
        $user = User::factory()->make()->toArray();
        $user['email'] = 'adu@oif.pl';
        $user['password'] = '!@#$1234Qwer';
        $user['password_confirmation'] = '!@#$1234Qwer';

        $responseUser = $this->postJson($this->apiUrl . 'users', $user)
            ->assertStatus(201)
            ->assertJsonStructure([
                'user' => ['id']
            ]);

        $this->assertIsNumeric($responseUser['user']['id']);

        //db verification
        $dbUser = User::find($responseUser['user']['id']);
        $this->assertEquals($dbUser['email'], $user['email']);
        $this->assertEquals($dbUser['name'], $user['name']);
        $this->assertEquals(Hash::check($user['password'], $dbUser['password']), true);
    }


}

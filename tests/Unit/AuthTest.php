<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;
use Tests\Helpers\UserHelper;

class AuthTest extends TestCase
{
    use UserHelper,
    RefreshDatabase,
    DatabaseMigrations;


    public function test_user_can_login_with_valid_credencials(): void
    {
        $this->createUser();

        $credencials = [
            'email' => $this->userEmail,
            'password' => $this->userPassword
        ];

        $isLogged = Auth::attempt($credencials);

        $this->assertTrue($isLogged);
    }

    public function test_user_cant_login_with_valid_credencials_when_user_is_deleted(): void
    {
        $this->createUser();
        $this->user->delete();

        $credencials = [
            'email' => $this->userEmail,
            'password' => $this->userPassword
        ];

        $isLogged = Auth::attempt($credencials);

        $this->assertFalse($isLogged);
    }


}

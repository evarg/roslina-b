<?php

namespace Tests\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

trait UserHelper {
    private $userEmail = 'grave432@gmail.com';
    private $userPassword = '!@#$1234Qwer';
    private $user;

    public function createUser(){
        $this->user = User::factory()->create([
            'email' => $this->userEmail,
            'password' => Hash::make($this->userPassword)
        ]);
    }

    public function getCredencialsValid(){
        return [
            'email' => $this->userEmail,
            'password' => $this->userPassword
        ];
    }

    public function getCredencialsInvalid(){
        return [
            'email' => $this->userEmail,
            'password' => 'asdf'
        ];
    }

    public function getCredencialsWithoutEmail(){
        return [
            'email' => '',
            'password' => $this->userPassword
        ];
    }

    public function getCredencialsWithoutPassword(){
        return [
            'email' => $this->userEmail,
            'password' => ''
        ];
    }

    public function getCredencialsWithInvalidEmail(){
        return [
            'email' => 'asdf@',
            'password' => $this->userPassword
        ];
    }


}

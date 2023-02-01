<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    use DatabaseMigrations;


    /**
     * test login by a user
     *
     * @return void
     */
    public function test_login_user()
    {
        $username = "test";
        $mobile   = "09118412257";
        $password = "123456";

        User::factory()->create([
            "username" => $username,
            "mobile"   => $mobile,
            "password" => Hash::make($password),
        ]);

        $this->postJson('/api/auth/login', ["username" => $username, "password" => $password])
             ->assertStatus(200)
        ;
    }
}

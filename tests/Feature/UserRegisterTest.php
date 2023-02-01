<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserRegisterTest extends TestCase
{
    use DatabaseMigrations;





    /**
     * test registration of a user
     *
     * @return void
     */
    public function test_register_user()
    {
        $data = [
            "email"                 => "test@info.com",
            "username"              => "testing",
            "name"                  => "test",
            "mobile"                  => "09118412265",
            "password"              => "12345678",
            "password_confirmation" => "12345678",
        ];

        $this->postJson("/api/auth/register", $data)
             ->assertStatus(200)
        ;

        $this->assertDatabaseHas("users", [
            "email"    => "test@info.com",
            "username" => "testing",
            "name"     => "test",
            "mobile"     => "09118412265",
        ]);
    }



    /**
     * test validation errors of registration
     *
     * @return void
     */
    public function test_register_Validation()
    {
        $data = [
            "email"    => "something",
            "name"     => "test",
            "password" => "123456",
        ];

        $this->postJson("/api/auth/register", $data)
             ->assertJsonValidationErrors([
                 "email",
                 "username",
                 "password",
                 "mobile",
             ])
        ;

    }
}

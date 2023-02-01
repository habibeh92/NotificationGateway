<?php

namespace App\Interfaces;

use App\Models\User;
use Laravel\Sanctum\NewAccessToken;

interface UserRepositoryInterface
{
    /**
     * register the user
     *
     * @param array $data
     *
     * @return User
     */
    public function register(array $data): User;



    /**
     * find user model by the username
     *
     * @param string $username
     *
     * @return User
     */
    public function findByUsername(string $username): User;



    /**
     * Log out the current user
     *
     * @return bool
     */
    public function logout(): bool;



    /**
     * create new access token
     *
     * @return NewAccessToken
     */
    public function createToken(): NewAccessToken;
}

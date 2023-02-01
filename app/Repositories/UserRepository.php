<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\NewAccessToken;

class UserRepository implements UserRepositoryInterface
{

    /**
     * @var User
     */
    protected User $model;



    /**
     * UserRepository constructor
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }



    /**
     * @inheritDoc
     */
    public function register(array $data): User
    {
        return $this->model = $this->model->create($data);
    }



    /**
     * @inheritDoc
     */
    public function findByUsername(string $username): User
    {
        return $this->model->where("username", $username)->firstOrNew();
    }



    /**
     * @inheritDoc
     */
    public function logout(): bool
    {
        return Auth::user()->tokens()->delete();
    }



    /**
     * @inheritDoc
     */
    public function createToken(): NewAccessToken
    {
        $this->logout();
        return Auth::user()->createToken("API TOKEN");
    }
}

<?php

namespace Database\Seeders;

use App\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;



    /**
     * UserController constructor
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }



    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!$this->userRepository->findByUsername("test")->exists) {
            $this->userRepository->register([
                "name"              => "test",
                "username"          => "test",
                "password"          => Hash::make("123456"),
                "email"             => "test@info.com",
                "mobile"            => "09" . fake()->unique()->randomNumber(9, true),
                'email_verified_at' => now(),
            ]);
        }
    }
}

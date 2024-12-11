<?php


namespace App\Services;


use App\Repositories\UserRepository;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * User logout
     * @return void
     */
    public function logout(): void
    {
        $this->userRepository->logout();
    }

}

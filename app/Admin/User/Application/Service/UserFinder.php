<?php

namespace App\Admin\User\Application\Service;

use App\Admin\User\Domain\Port\UserRepository;
use App\Admin\User\Domain\User;

class UserFinder
{
    public function __construct(
        private readonly UserRepository $userRepository
    )
    {
    }

    public function findById(string $id): ?User
    {
        return $this->userRepository->searchById($id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->userRepository->searchByEmail($email);
    }
}

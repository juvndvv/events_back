<?php

namespace App\Admin\User\Domain\Services;

use App\Backoffice\User\Domain\Port\UserRepository;
use App\Backoffice\User\Domain\User;

class UserFinder
{
    public function __construct(
        private readonly UserRepository $userRepository
    )
    {
    }

    public function findById(string $id): ?User
    {
        return $this->userRepository->search($id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->userRepository->searchByEmail($email);
    }
}

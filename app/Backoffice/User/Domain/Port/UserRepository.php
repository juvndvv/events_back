<?php

namespace App\Backoffice\User\Domain\Port;

use App\Backoffice\User\Domain\User;

interface UserRepository
{
    public function save(User $user): void;

    public function update(User $user): void;

    public function search(string $id): ?User;

    public function searchByEmail(string $email): ?User;
}

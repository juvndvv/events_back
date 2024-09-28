<?php

namespace App\Admin\User\Domain\Port;

use App\Admin\User\Domain\User;

interface UserRepository
{
    public function save(User $user): void;

    public function update(User $user): void;

    public function search(string $id): ?User;

    public function searchByEmail(string $email): ?User;

    public function searchByToken(string $token): ?User;
}

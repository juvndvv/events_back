<?php

namespace App\Admin\User\Domain\Port;

use App\Admin\User\Domain\User;

interface UserRepository
{
    public function saveOrUpdate(User $user): void;
    public function searchById(string $id): ?User;
    public function searchByEmail(string $email): ?User;
    public function searchByToken(string $token): ?User;
    public function delete(User $user): void;
}

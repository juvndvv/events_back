<?php

namespace App\Admin\User\Infrastructure\Repository;

use App\Admin\User\Domain\Port\UserRepository;
use App\Admin\User\Domain\User;
use Illuminate\Support\Facades\DB;

class MySqlUserRepository implements UserRepository
{
    public function save(User $user): void
    {
    }

    public function update(User $user): void
    {
    }

    public function search(string $id): ?User
    {
        return null;
    }

    public function searchByEmail(string $email): ?User
    {
        return null;
    }

    public function searchByToken(string $token): ?User
    {
        $db = DB::table('users')
            ->where('email', '=', 'jdanielforga@gmail.com')
            ->first();

        return User::fromPrimitives($db);
    }
}

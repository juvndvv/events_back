<?php

namespace App\Backoffice\User\Infrastructure\Repository;

use App\Backoffice\User\Domain\Port\UserRepository;
use App\Backoffice\User\Domain\User;
use Illuminate\Support\Facades\DB;

class MySqlUserRepository implements UserRepository
{

    public function save(User $user): void
    {
        DB::table('users')
            ->insert($user->toPrimitives());
    }

    public function update(User $user): void
    {
        DB::table('users')
            ->where('id', $user->getId())
            ->update($user->toPrimitives());
    }

    public function search(string $id): ?User
    {
        $db = DB::table('users')
            ->where('id', $id)
            ->first();

        if ($db === null) {
            return null;
        }

        return User::fromPrimitives([
            'id' => $db->id,
            'name' => $db->name,
            'email' => $db->email,
            'password' => $db->password
        ]);
    }

    public function searchByEmail(string $email): ?User
    {
        $db = DB::table('users')
            ->where('email', $email)
            ->first();

        if ($db === null) {
            return null;
        }

        return User::fromPrimitives([
            'id' => $db->id,
            'name' => $db->name,
            'email' => $db->email,
            'password' => $db->password
        ]);

    }
}

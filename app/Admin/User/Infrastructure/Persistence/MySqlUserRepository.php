<?php

namespace App\Admin\User\Infrastructure\Persistence;

use App\Admin\User\Domain\Port\UserRepository;
use App\Admin\User\Domain\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class MySqlUserRepository implements UserRepository
{
    private Builder $builder;

    public function __construct()
    {
        $this->builder = EloquentUserModel::query();
    }

    public function getBuilder(): Builder
    {
        return $this->builder->clone();
    }

    public function saveOrUpdate(User $user): void
    {
        $db = $this->builder->where('id', '=', $user->getId())->first();

        if (!$db) {
            $this->builder->insert($user->toPrimitives());
            return;
        }

        $db->update($user->toPrimitives());
    }

    public function searchById(string $id): ?User
    {
        $db = $this->getBuilder()->where('id', '=', $id);

        if ($db->exists()) {
            return User::fromPrimitives($db->first()->toArray());
        }

        return null;
    }

    public function searchByEmail(string $email): ?User
    {
        $db = $this->getBuilder()->where('email', '=', $email);

        if ($db->exists()) {
            return User::fromPrimitives($db->first()->toArray());
        }

        return null;
    }

    public function searchByToken(string $token): ?User
    {
        $db = $this->getBuilder()->where('token', '=', $token);

        if ($db->exists()) {
            return User::fromPrimitives($db->first()->toArray());
        }

        return null;
    }

    public function delete(User $user): void
    {
        $this->getBuilder()->where('id', '=', $user->getId())->first()->delete();
    }
}

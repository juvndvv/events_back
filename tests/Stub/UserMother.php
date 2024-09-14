<?php

namespace Tests\Stub;

use App\Backoffice\User\Domain\User;
use App\Backoffice\User\Domain\ValueObject\UserEmail;
use App\Backoffice\User\Domain\ValueObject\UserHashPassword;
use App\Backoffice\User\Domain\ValueObject\UserName;
use App\Shared\Domain\Identifier\UserId;

class UserMother extends User
{
    public static function son(
        ?string $id = null,
        ?string $name = null,
        ?string $email = null,
        ?string $password = null,
    ): User {
        return new parent(
            id: $id ? UserId::create($id) : UserId::generate(),
            name: $name ? UserName::create($name) : UserName::generate(),
            email: $email ? UserEmail::create($email) : UserEmail::generate(),
            password: $password ? UserHashPassword::create($password) : UserHashPassword::generate()
        );
    }
}

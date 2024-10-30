<?php

declare(strict_types=1);

namespace Tests\Shared\Domain\ValueObject;


use App\Shared\Domain\ValueObject\UserId;

class UserIdMother extends UserId
{
    public static function random(): UserId
    {
        return UserId::generate();
    }
}

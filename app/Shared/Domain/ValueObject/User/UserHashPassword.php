<?php

namespace App\Shared\Domain\ValueObject\User;

use App\Shared\Domain\ValueObject\StringValueObject;

class UserHashPassword extends StringValueObject
{
    protected const MIN_LENGTH = 64;
    protected const MAX_LENGTH = 64;

    public static function create(string $value): self
    {
        return new self($value, self::MIN_LENGTH, self::MAX_LENGTH);
    }
}

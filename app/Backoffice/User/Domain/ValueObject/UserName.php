<?php

namespace App\Backoffice\User\Domain\ValueObject;

use App\Shared\Domain\ValueObject\StringValueObject;

class UserName extends StringValueObject
{
    protected const MIN_LENGTH = 3;
    protected const MAX_LENGTH = 100;

    public static function create(string $value): self
    {
        return parent::doCreate($value, self::MIN_LENGTH, self::MAX_LENGTH);
    }
}

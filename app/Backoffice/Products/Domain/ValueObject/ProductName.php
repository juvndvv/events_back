<?php

namespace App\Backoffice\Products\Domain\ValueObject;

use App\Shared\Domain\ValueObject\StringValueObject;

class ProductName extends StringValueObject
{
    private const MIN_LENGTH = 3;
    private const MAX_LENGTH = 100;

    public static function create(string $value): self
    {
        return parent::doCreate($value, self::MIN_LENGTH, self::MAX_LENGTH);
    }
}

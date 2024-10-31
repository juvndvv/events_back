<?php

namespace App\Backoffice\Products\Domain\ValueObject;

use App\Shared\Domain\ValueObject\StringValueObject;

class ProductDescription extends StringValueObject
{
    private const MIN_LENGTH = 3;
    private const MAX_LENGTH = 1200;
    private const ALLOW_EMPTY = true;

    public static function create(string $value): self
    {
        return parent::doCreate($value, self::MIN_LENGTH, self::MAX_LENGTH, self::ALLOW_EMPTY);
    }
}

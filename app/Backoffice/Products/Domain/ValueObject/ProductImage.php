<?php

namespace App\Backoffice\Products\Domain\ValueObject;

use App\Shared\Domain\ValueObject\StringValueObject;

class ProductImage extends StringValueObject
{
    private const MIN_LENGTH = 3;
    private const MAX_LENGTH = 1200;

    public static function create(string $value)
    {
        parent::doCreate($value, self::MIN_LENGTH, self::MAX_LENGTH);
    }
}

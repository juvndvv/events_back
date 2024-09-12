<?php

namespace App\Backoffice\Products\Domain\ValueObject;

use App\Shared\Domain\ValueObject\FloatValueObject;

class ProductPrice extends FloatValueObject
{
    private const MIN = 0;
    private const MAX_DECIMALS = 2;

    public static function create(float $value): self
    {
        return parent::doCreate($value, min: self::MIN, decimals: self::MAX_DECIMALS);
    }
}

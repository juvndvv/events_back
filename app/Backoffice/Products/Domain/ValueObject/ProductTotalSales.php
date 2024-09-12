<?php

namespace App\Backoffice\Products\Domain\ValueObject;

use App\Shared\Domain\ValueObject\IntegerValueObject;

class ProductTotalSales extends IntegerValueObject
{
    private const MIN = 0;

    public static function create(int $value): self
    {
        return parent::doCreate($value, min: self::MIN);
    }
}

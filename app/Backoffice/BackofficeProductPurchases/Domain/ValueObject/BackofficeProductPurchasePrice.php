<?php

namespace App\Backoffice\BackofficeProductPurchases\Domain\ValueObject;

use App\Shared\Domain\ValueObject\FloatValueObject;

class BackofficeProductPurchasePrice extends FloatValueObject
{
    protected const MIN = 0;
    protected const MAX_DECIMALS = 2;

    public static function create(float $value): self
    {
        return parent::doCreate($value, min: self::MIN, decimals: self::MAX_DECIMALS);
    }
}

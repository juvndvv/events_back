<?php

namespace App\Backoffice\BackofficeProductPurchases\Domain\ValueObject;

use App\Shared\Domain\ValueObject\IntegerValueObject;

class BackofficeProductPurchaseQuantity extends IntegerValueObject
{
    protected const MIN_VALUE = 1;

    public static function create(int $value): self
    {
        return parent::doCreate($value, self::MIN_VALUE);
    }
}

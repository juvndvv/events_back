<?php

namespace App\Backoffice\BackofficeProductPurchases\Domain\ValueObject;

use App\Shared\Domain\ValueObject\StringValueObject;

class BackofficeProductPurchaseBuyerName extends StringValueObject
{
    private const MIN_LENGTH = 3;
    private const MAX_LENGTH = 100;

    public static function create(string $value)
    {
        parent::doCreate($value, self::MIN_LENGTH, self::MAX_LENGTH);
    }
}

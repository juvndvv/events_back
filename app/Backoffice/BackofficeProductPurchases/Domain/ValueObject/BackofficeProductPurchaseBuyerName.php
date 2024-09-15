<?php

namespace App\Backoffice\BackofficeProductPurchases\Domain\ValueObject;

use App\Shared\Domain\ValueObject\StringValueObject;

class BackofficeProductPurchaseBuyerName extends StringValueObject
{
    protected const MIN_LENGTH = 3;
    protected const MAX_LENGTH = 100;

    public static function create(string $value): self
    {
        return parent::doCreate($value, self::MIN_LENGTH, self::MAX_LENGTH);
    }
}

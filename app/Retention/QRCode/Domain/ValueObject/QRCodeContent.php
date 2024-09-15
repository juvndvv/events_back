<?php

namespace App\Retention\QRCode\Domain\ValueObject;

use App\Shared\Domain\ValueObject\StringValueObject;

class QRCodeContent extends StringValueObject
{
    protected const MIN_LENGTH = 1;
    protected const MAX_LENGTH = 10000;

    public static function create(string $value): self
    {
        return parent::doCreate($value, self::MIN_LENGTH, self::MAX_LENGTH);
    }
}

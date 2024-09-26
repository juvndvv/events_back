<?php

namespace App\Admin\Customer\Domain\ValueObject;

use App\Shared\Domain\ValueObject\StringValueObject;

class CustomerName extends StringValueObject
{
    public static function create(string $value, ?int $min = 1, ?int $max = 200): self
    {
        return parent::doCreate($value, $min, $max);
    }
}

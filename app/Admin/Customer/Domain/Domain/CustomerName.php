<?php

declare(strict_types=1);

namespace App\Admin\Customer\Domain\Domain;


use App\Shared\Domain\ValueObject\StringValueObject;

class CustomerName extends StringValueObject
{
    public static function create(string $value): self
    {
        return parent::doCreate($value);
    }
}

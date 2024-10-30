<?php

declare(strict_types=1);

namespace App\Backoffice\Products\Domain\ValueObject;


use App\Shared\Domain\Utils\Optional;

/**
 * @extends Optional<ProductName>
 */
class OptionalProductName extends Optional
{
    public function getType(): string
    {
        return ProductName::class;
    }
}

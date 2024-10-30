<?php

declare(strict_types=1);

namespace App\Backoffice\Products\Domain\ValueObject;


use App\Shared\Domain\Utils\Optional;

/**
 * @extends Optional<ProductDescription>
 */
class OptionalProductDescription extends Optional
{
    public function getType(): string
    {
        return ProductDescription::class;
    }
}

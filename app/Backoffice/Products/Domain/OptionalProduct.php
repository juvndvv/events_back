<?php

declare(strict_types=1);

namespace App\Backoffice\Products\Domain;

use App\Shared\Domain\Utils\Optional;

/**
 * @extends Optional<Product>
 */
class OptionalProduct extends Optional
{
    public function getType(): string
    {
        return Product::class;
    }
}

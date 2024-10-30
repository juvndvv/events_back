<?php

declare(strict_types=1);

namespace App\Backoffice\Products\Domain\ValueObject;


use App\Shared\Domain\Utils\Optional;
use App\Shared\Domain\ValueObject\ProductId;

/**
 * @extends Optional<ProductId>
 */
class OptionalProductId extends Optional
{
    public function getType(): string
    {
        return ProductId::class;
    }
}

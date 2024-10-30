<?php

declare(strict_types=1);

namespace Tests\Backoffice\Products\Domain\ValueObject;


use App\Shared\Domain\ValueObject\ProductId;

class ProductIdMother extends ProductId
{
    public static function random(): ProductId
    {
        return ProductId::generate();
    }
}

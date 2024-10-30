<?php

declare(strict_types=1);

namespace Tests\Backoffice\Products\Domain\ValueObject;


use App\Backoffice\Products\Domain\ValueObject\ProductPrice;

class ProductPriceMother extends ProductPrice
{
    public static function random(): ProductPrice
    {
        return ProductPrice::create(round(100 + mt_rand() / mt_getrandmax() * (100 - 0.1), 2));
    }
}

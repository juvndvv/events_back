<?php

declare(strict_types=1);

namespace Tests\Backoffice\Products\Domain\ValueObject;


use App\Backoffice\Products\Domain\ValueObject\ProductName;

class ProductNameMother extends ProductName
{
    public static function random(): ProductName
    {
        return new ProductName(uniqid('product-name', true));
    }
}

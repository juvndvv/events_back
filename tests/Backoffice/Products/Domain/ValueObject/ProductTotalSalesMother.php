<?php

declare(strict_types=1);

namespace Tests\Backoffice\Products\Domain\ValueObject;


use App\Backoffice\Products\Domain\ValueObject\ProductTotalSales;

class ProductTotalSalesMother extends ProductTotalSales
{
    public static function random(): ProductTotalSales
    {
        return ProductTotalSales::create(rand(0, 100));
    }
}

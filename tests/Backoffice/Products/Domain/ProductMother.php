<?php

declare(strict_types=1);

namespace Tests\Backoffice\Products\Domain;


use App\Backoffice\Products\Domain\Product;
use Tests\Backoffice\Products\Domain\ValueObject\ProductDescriptionMother;
use Tests\Backoffice\Products\Domain\ValueObject\ProductIdMother;
use Tests\Backoffice\Products\Domain\ValueObject\ProductNameMother;
use Tests\Backoffice\Products\Domain\ValueObject\ProductPriceMother;
use Tests\Backoffice\Products\Domain\ValueObject\ProductTotalSalesMother;
use Tests\Shared\Domain\ValueObject\UserIdMother;

class ProductMother extends Product
{
    public static function random(): Product
    {
        return new Product(
            id: ProductIdMother::random(),
            name: ProductNameMother::random(),
            description: ProductDescriptionMother::random(),
            price: ProductPriceMother::random(),
            totalSales: ProductTotalSalesMother::random(),
            creator: UserIdMother::random(),
        );
    }
}

<?php

namespace Stub\Backoffice\Product;

use App\Backoffice\Products\Domain\Product;
use App\Backoffice\Products\Domain\ValueObject\ProductDescription;
use App\Backoffice\Products\Domain\ValueObject\ProductImage;
use App\Backoffice\Products\Domain\ValueObject\ProductName;
use App\Backoffice\Products\Domain\ValueObject\ProductPrice;
use App\Backoffice\Products\Domain\ValueObject\ProductTotalSales;
use App\Shared\Domain\Identifier\ProductId;
use App\Shared\Domain\Identifier\UserId;

class ProductStub extends Product
{
    public function __construct(
        ?int $id = null,
        ?string $name = null,
        ?string $description = null,
        ?string $image = null,
        ?int $price = null,
        ?int $totalSales = null,
        ?string $userId = null,
    )
    {
        parent::__construct(
            id: $id ?: ProductId::generate(),
            name: $name ?: ProductName::create(uniqid('product_name-')),
            description: $description ?: ProductDescription::create(uniqid('product_description-')),
            image: $image ?: ProductImage::create(uniqid('product_image-')),
            price: $price ?: ProductPrice::create(1 + mt_rand() / mt_getrandmax() * (50 - 1)),
            totalSales: $totalSales ?: ProductTotalSales::create(mt_rand() / mt_getrandmax()),
            creatorId: $userId ?: UserId::generate(),
        );
    }
}

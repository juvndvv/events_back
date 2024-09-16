<?php

namespace Tests\Stub\Backoffice;

use App\Backoffice\Products\Domain\Product;
use App\Backoffice\Products\Domain\ValueObject\ProductDescription;
use App\Backoffice\Products\Domain\ValueObject\ProductImage;
use App\Backoffice\Products\Domain\ValueObject\ProductName;
use App\Backoffice\Products\Domain\ValueObject\ProductPrice;
use App\Backoffice\Products\Domain\ValueObject\ProductTotalSales;
use App\Shared\Domain\Identifier\ProductId;
use App\Shared\Domain\Identifier\UserId;
use App\Shared\Domain\ValueObject\DateTimeValueObject;
use DateTimeImmutable;

class ProductMother extends Product
{
    public static function son(
        ?string $id = null,
        ?string $name = null,
        ?string $description = null,
        ?string $image = null,
        ?int $price = null,
        ?int $totalSales = null,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null,
        ?DateTimeImmutable $deletedAt = null,
        ?int $createdBy = null,
        ?int $updatedBy = null,
        ?int $deletedBy = null,
        ?bool $deleted = false,
    ): Product {
        if ($deleted || $deletedAt || $deletedBy) {
            $deletedBy = $deletedBy ?? UserId::generate();
            $deletedAt = $deletedAt ?? DateTimeValueObject::create(new DateTimeImmutable());
        }

        return new parent(
            id: $id ? ProductId::create($id) : ProductId::generate(),
            name: $name ? ProductName::create($name) : ProductName::create(uniqid('product_name-')),
            description: $description ? ProductDescription::create($description) : ProductDescription::create(uniqid('product_description-')),
            image: $image ? ProductImage::create($image) : ProductImage::create(uniqid('product_image-')),
            price: $price ? ProductPrice::create($price) : ProductPrice::create(round(1 + mt_rand() / mt_getrandmax() * (50 - 1), 2)),
            totalSales: $totalSales ? ProductTotalSales::create($totalSales) : ProductTotalSales::create(mt_rand() / mt_getrandmax()),
            createdBy: $createdBy ? UserId::create($createdBy) : UserId::generate(),
            createdAt:  $createdAt ? DateTimeValueObject::create($createdAt) : DateTimeValueObject::create(new DateTimeImmutable()),
            updatedBy: $updatedBy ? UserId::create($updatedBy) : UserId::generate(),
            updatedAt: $updatedAt ? DateTimeValueObject::create($updatedAt) : DateTimeValueObject::create(new DateTimeImmutable()),
            deletedBy: $deletedBy,
            deletedAt: $deletedAt,
        );
    }
}

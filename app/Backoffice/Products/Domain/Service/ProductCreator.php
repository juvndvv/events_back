<?php

namespace App\Backoffice\Products\Domain\Service;

use App\Backoffice\Products\Domain\Exceptions\ProductAlreadyExists;
use App\Backoffice\Products\Domain\Port\ProductRepository;
use App\Backoffice\Products\Domain\Product;
use App\Backoffice\Products\Domain\ValueObject\OptionalProductDescription;
use App\Backoffice\Products\Domain\ValueObject\ProductName;
use App\Shared\Domain\ValueObject\Currency;
use App\Shared\Domain\ValueObject\ProductId;
use App\Shared\Domain\ValueObject\UserId;

readonly class ProductCreator
{
    public function __construct(
        private ProductSearcher   $searcher,
        private ProductRepository $repository
    )
    {
    }

    public function create(
        ProductId                  $id,
        ProductName                $name,
        OptionalProductDescription $description,
        Currency                   $price,
        UserId                     $creatorId
    ): Product
    {
        $product = Product::create(
            id: $id,
            name: $name,
            description: $description,
            price: $price,
            creatorId: $creatorId
        );

        $this->ensureProductDoesntExists($product->id());

        $this->repository->save($product);

        return $product;
    }

    private function ensureProductDoesntExists(ProductId $id): void
    {
        $this
            ->searcher
            ->searchById($id)
            ->ifPresent(fn() => throw new ProductAlreadyExists($id));
    }
}

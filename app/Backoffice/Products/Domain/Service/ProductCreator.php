<?php

namespace App\Backoffice\Products\Domain\Service;

use App\Backoffice\Products\Domain\Exceptions\ProductAlreadyExists;
use App\Backoffice\Products\Domain\Port\ProductRepository;
use App\Backoffice\Products\Domain\Product;
use App\Backoffice\Products\Domain\ValueObject\ProductDescription;
use App\Backoffice\Products\Domain\ValueObject\ProductImage;
use App\Backoffice\Products\Domain\ValueObject\ProductName;
use App\Backoffice\Products\Domain\ValueObject\ProductPrice;
use App\Shared\Domain\Identifier\UserId;

class ProductCreator
{
    public function __construct(
        private readonly ProductFinder $finder,
        private readonly ProductRepository $repository
    )
    {
    }

    public function __invoke(
        ProductName $name,
        ProductDescription $description,
        ProductImage $image,
        ProductPrice $price,
        UserId $creatorId
    ): Product {
        $product = Product::create($name, $description, $image, $price, $creatorId);

        $this->ensureProductDoesntExists($product->getId());

        $this->repository->save($product);

        return $product;
    }

    private function ensureProductDoesntExists(string $id): void
    {
        $product = $this->finder->__invoke($id);

        if (null !== $product) {
            throw new ProductAlreadyExists();
        }
    }
}

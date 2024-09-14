<?php

namespace App\Backoffice\Products\Domain\Service;

use App\Backoffice\Products\Domain\Exceptions\ProductDoesntExist;
use App\Backoffice\Products\Domain\Port\ProductRepository;
use App\Backoffice\Products\Domain\Product;

class ProductUpdater
{
    public function __construct(
        private readonly ProductFinder $productFinder,
        private readonly ProductRepository $repository
    )
    {
    }

    public function __invoke(
        string $updater,
        string $id,
        ?string $name,
        ?string $description,
        ?float $price,
        ?string $image,
    ): Product {
        $product = $this->productFinder->__invoke($id);

        if (null === $product) {
            throw new ProductDoesntExist($id);
        }

        !$name ?: $product->updateName($name, $updater);
        !$description ?: $product->updateDescription($description, $updater);
        !$price ?: $product->updatePrice($price, $updater);
        !$image ?: $product->updateImage($image, $updater);

        $this->repository->update($product);

        // TODO publish events

        return $product;
    }
}

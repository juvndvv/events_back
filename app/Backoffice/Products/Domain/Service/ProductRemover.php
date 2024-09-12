<?php

namespace App\Backoffice\Products\Domain\Service;

use App\Backoffice\Products\Domain\Exceptions\ProductDoesntExist;
use App\Backoffice\Products\Domain\Port\ProductRepository;
use App\Backoffice\Products\Domain\Product;

class ProductRemover
{
    public function __construct(
        private readonly ProductRepository $repository,
        private readonly ProductFinder $finder
    )
    {
    }

    /**
     * @throws ProductDoesntExist
     */
    public function __invoke(string $id): Product
    {
        $product = $this->finder->__invoke($id);

        if (null === $product) {
            throw new ProductDoesntExist();
        }

        $this->repository->delete($product);
        $product->delete();

        return $product;
    }
}

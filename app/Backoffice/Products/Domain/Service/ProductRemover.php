<?php

namespace App\Backoffice\Products\Domain\Service;

use App\Backoffice\Products\Domain\Exceptions\ProductDoesntExist;
use App\Backoffice\Products\Domain\Port\ProductRepository;
use App\Backoffice\Products\Domain\Product;
use App\Shared\Domain\ValueObject\ProductId;

readonly class ProductRemover
{
    public function __construct(
        private ProductRepository $repository,
        private ProductSearcher $searcher
    )
    {
    }

    /**
     * @throws ProductDoesntExist
     */
    public function removeById(ProductId $id): Product
    {
        $product = $this->retrieveProductOrFail($id);
        $this->repository->delete($product);

        return $product;
    }

    private function retrieveProductOrFail(ProductId $id): Product
    {
        return $this->searcher
            ->searchById($id)
            ->ifNotPresent(fn () => throw new ProductDoesntExist())
            ->get();
    }
}

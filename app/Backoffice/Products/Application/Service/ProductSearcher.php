<?php

namespace App\Backoffice\Products\Application\Service;

use App\Backoffice\Products\Domain\OptionalProduct;
use App\Backoffice\Products\Domain\Port\ProductRepository;
use App\Shared\Domain\ValueObject\ProductId;

readonly class ProductSearcher
{
    public function __construct(
        private ProductRepository $repository,
    )
    {
    }

    public function searchById(ProductId $id):OptionalProduct
    {
        return $this->repository->search($id);
    }
}

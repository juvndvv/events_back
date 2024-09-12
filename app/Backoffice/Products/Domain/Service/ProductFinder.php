<?php

namespace App\Backoffice\Products\Domain\Service;

use App\Backoffice\Products\Domain\Port\ProductRepository;
use App\Backoffice\Products\Domain\Product;

class ProductFinder
{
    public function __construct(
        private readonly ProductRepository $repository,
    )
    {
    }

    public function __invoke(string $id): ?Product
    {
        return $this->repository->search($id);
    }
}

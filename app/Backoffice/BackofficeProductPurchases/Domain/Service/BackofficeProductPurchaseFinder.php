<?php

namespace App\Backoffice\BackofficeProductPurchases\Domain\Service;

use App\Backoffice\BackofficeProductPurchases\Domain\BackofficeProductPurchase;
use App\Backoffice\BackofficeProductPurchases\Domain\Port\BackofficeProductPurchaseRepository;

class BackofficeProductPurchaseFinder
{
    public function __construct(
        private readonly BackofficeProductPurchaseRepository $repository,
    )
    {
    }

    public function __invoke(string $id): ?BackofficeProductPurchase
    {
        return $this->repository->search($id);
    }
}

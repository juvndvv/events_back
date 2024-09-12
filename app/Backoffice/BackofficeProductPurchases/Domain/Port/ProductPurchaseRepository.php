<?php

namespace App\Backoffice\BackofficeProductPurchases\Domain\Port;


use App\Backoffice\BackofficeProductPurchases\Domain\BackofficeProductPurchase;

interface ProductPurchaseRepository
{
    public function save(BackofficeProductPurchase $productPurchase): void;
    public function find(string $id): ?BackofficeProductPurchase;
}

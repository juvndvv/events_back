<?php

namespace App\Backoffice\BackofficeProductPurchases\Domain\Port;


use App\Backoffice\BackofficeProductPurchases\Domain\BackofficeProductPurchase;

interface BackofficeProductPurchaseRepository
{
    public function save(BackofficeProductPurchase $productPurchase): void;
    public function search(string $id): ?BackofficeProductPurchase;
    public function searchByQRCode(array $file): ?BackofficeProductPurchase;
}

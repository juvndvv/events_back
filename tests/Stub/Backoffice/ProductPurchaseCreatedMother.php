<?php

namespace Tests\Stub\Backoffice;

use App\Backoffice\BackofficeProductPurchases\Domain\Event\ProductPurchaseCreated;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseId;

class ProductPurchaseCreatedMother extends ProductPurchaseCreated
{
    public static function son(): ProductPurchaseCreated
    {
        return new parent(
            BackofficeProductPurchaseId::generate()->value(),
        );
    }
}

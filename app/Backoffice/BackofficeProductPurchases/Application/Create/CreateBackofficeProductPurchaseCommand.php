<?php

namespace App\Backoffice\BackofficeProductPurchases\Application\Create;

class CreateBackofficeProductPurchaseCommand
{
    public function __construct(
        public readonly string $productId,
        public readonly string $creatorId,
    )
    {
    }
}

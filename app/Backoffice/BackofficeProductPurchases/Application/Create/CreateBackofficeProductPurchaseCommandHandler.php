<?php

namespace App\Backoffice\BackofficeProductPurchases\Application\Create;

use App\Backoffice\BackofficeProductPurchases\Domain\Service\BackofficeProductPurchaseCreator;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseBuyerEmail;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseBuyerName;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseQuantity;
use App\Shared\Domain\Identifier\ProductId;
use App\Shared\Domain\Identifier\UserId;

class CreateBackofficeProductPurchaseCommandHandler
{
    public function __construct(
        private readonly BackofficeProductPurchaseCreator $creator
    )
    {
    }

    public function __invoke(CreateBackofficeProductPurchaseCommand $command): string
    {
        $purchase = $this->creator->__invoke(
            productId: ProductId::create($command->productId),
            creatorId: UserId::create($command->creatorId),
            purchaseQuantity: BackofficeProductPurchaseQuantity::create($command->quantity),
            name: BackofficeProductPurchaseBuyerName::create($command->name),
            email: BackofficeProductPurchaseBuyerEmail::create($command->email),
        );

        // TODO publish events

        return $purchase->getId();
    }
}

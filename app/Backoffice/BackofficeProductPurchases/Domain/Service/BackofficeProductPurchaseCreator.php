<?php

namespace App\Backoffice\BackofficeProductPurchases\Domain\Service;

use App\Backoffice\BackofficeProductPurchases\Domain\BackofficeProductPurchase;
use App\Backoffice\BackofficeProductPurchases\Domain\Port\BackofficeProductPurchaseRepository;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseBuyerEmail;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseBuyerName;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseQuantity;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseUnitPrice;
use App\Backoffice\Products\Domain\Exceptions\ProductDoesntExist;
use App\Backoffice\Products\Domain\Product;
use App\Backoffice\Products\Domain\Service\ProductFinder;
use App\Backoffice\User\Domain\Exception\UserDoesntExist;
use App\Backoffice\User\Domain\Services\UserFinder;
use App\Shared\Domain\Identifier\ProductId;
use App\Shared\Domain\Identifier\UserId;
use App\Store\ProductPurchases\Domain\Entity\BackofficeProductPurchaseBuyer;

class BackofficeProductPurchaseCreator
{
    public function __construct(
        private readonly BackofficeProductPurchaseRepository $repository,
        private readonly ProductFinder                       $productFinder,
        private readonly UserFinder                          $userFinder,
    )
    {
    }

    public function __invoke(
        ProductId                           $productId,
        UserId                              $creatorId,
        BackofficeProductPurchaseQuantity   $purchaseQuantity,
        BackofficeProductPurchaseBuyerName  $name,
        BackofficeProductPurchaseBuyerEmail $email,
    ): BackofficeProductPurchase
    {
        $product = $this->ensureProductExistsAndRetrieveIt($productId);
        $this->ensureUserExist($creatorId);

        $unitPrice = BackofficeProductPurchaseUnitPrice::create($product->getPrice());

        $buyer = BackofficeProductPurchaseBuyer::create($name, $email);

        $purchase = BackofficeProductPurchase::create(
            productId: $productId,
            creatorId: $creatorId,
            unitPrice: $unitPrice,
            quantity: $purchaseQuantity,
            buyer: $buyer,
        );

        $this->repository->save($purchase);

        return $purchase;
    }

    private function ensureProductExistsAndRetrieveIt(ProductId $productId): Product
    {
        $product = $this->productFinder->__invoke($productId->value());

        if (null === $product)
            throw new ProductDoesntExist($productId->value());

        return $product;
    }

    public function ensureUserExist(UserId $userId): void
    {
        $user = $this->userFinder->findById($userId->value());

        if (null === $user) {
            throw new UserDoesntExist($userId->value());
        }
    }
}

<?php

namespace Tests\Stub;

use App\Backoffice\BackofficeProductPurchases\Domain\BackofficeProductPurchase;
use App\Backoffice\BackofficeProductPurchases\Domain\Entity\BackofficeProductPurchaseBuyer;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseBuyerEmail;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseBuyerName;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseId;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchasePrice;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseQuantity;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseTotalExpenses;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseUnitPrice;
use App\Shared\Domain\Identifier\ProductId;
use App\Shared\Domain\Identifier\UserId;
use App\Shared\Domain\ValueObject\DateTimeValueObject;
use DateTimeImmutable;

class BackofficeProductPurchaseMother extends BackofficeProductPurchase
{
    public static function son(
        ?string $id = null,
        ?string $productId = null,
        ?string $creatorId = null,
        ?string $buyerName = null,
        ?string $buyerEmail = null,
        ?float $unitPrice = null,
        ?int $quantity = null,
        ?int $expenses = null,
        ?int $purchasedAt = null
    )
    {
        if (null === $creatorId) {
            $creatorId = UserId::generate();
        } else {
            $creatorId = UserId::create($creatorId);
        }

        if (null === $buyerName) {
            $buyerName = BackofficeProductPurchaseBuyerName::generate();
        } else {
            $buyerName = BackofficeProductPurchaseBuyerName::create($buyerName);
        }

        if (null === $buyerEmail) {
            $buyerEmail = BackofficeProductPurchaseBuyerEmail::generate();
        } else {
            $buyerEmail = BackofficeProductPurchaseBuyerEmail::create($buyerEmail);
        }

        if (null === $unitPrice) {
            $unitPrice = BackofficeProductPurchaseUnitPrice::generate();
        } else {
            $unitPrice = BackofficeProductPurchaseUnitPrice::create($unitPrice);
        }

        if (null === $quantity) {
            $quantity = BackofficeProductPurchaseQuantity::generate();
        } else {
            $quantity = BackofficeProductPurchaseQuantity::create($quantity);
        }

        if (null === $expenses) {
            $expenses = BackofficeProductPurchaseTotalExpenses::generate();
        } else {
            $expenses = BackofficeProductPurchaseTotalExpenses::create($expenses);
        }

        $price = BackofficeProductPurchasePrice::create(round($quantity->value() * $unitPrice->value(), 2));

        $buyer = BackofficeProductPurchaseBuyer::create($buyerName, $buyerEmail);

        return new parent(
            id: $id ? BackofficeProductPurchaseId::create($id) : BackofficeProductPurchaseId::generate(),
            productId: $productId ? ProductId::create($productId) : ProductId::generate(),
            creatorId: $creatorId,
            unitPrice: $unitPrice,
            quantity: $quantity,
            price: $price,
            expenses: $expenses,
            buyer: $buyer,
            purchaseAt: $purchasedAt ? DateTimeValueObject::createFromUnixTime($purchasedAt) : DateTimeValueObject::create(new DateTimeImmutable()),
        );
    }
}

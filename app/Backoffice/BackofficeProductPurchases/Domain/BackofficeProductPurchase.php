<?php

namespace App\Backoffice\BackofficeProductPurchases\Domain;


use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\Identifier\ProductId;
use App\Store\ProductPurchases\Domain\Entity\BackofficeProductPurchaseBuyer;
use App\Store\ProductPurchases\Domain\Event\ProductPurchaseCreated;
use App\Store\ProductPurchases\Domain\ValueObject\BackofficeProductPurchaseDateTime;
use App\Store\ProductPurchases\Domain\ValueObject\BackofficeProductPurchaseId;
use App\Store\ProductPurchases\Domain\ValueObject\BackofficeProductPurchasePrice;
use DateTimeImmutable;

class BackofficeProductPurchase extends AggregateRoot
{
    private readonly BackofficeProductPurchaseId $id;
    private readonly ProductId $productId;
    private readonly BackofficeProductPurchaseBuyer $buyer;
    private readonly BackofficeProductPurchasePrice $purchasePrice;
    private readonly BackofficeProductPurchaseDateTime $purchaseAt;

    private function __construct(
        BackofficeProductPurchaseId       $id,
        ProductId                         $productId,
        BackofficeProductPurchasePrice    $purchasePrice,
        BackofficeProductPurchaseBuyer    $buyer,
        BackofficeProductPurchaseDateTime $purchaseAt,
    )
    {
        $this->id = $id;
        $this->productId = $productId;
        $this->buyer = $buyer;
        $this->purchasePrice = $purchasePrice;
        $this->purchaseAt = $purchaseAt;
    }

    public function getId(): string
    {
        return $this->id->value();
    }

    public function getProductId(): string
    {
        return $this->productId->value();
    }

    public function getPurchasePrice(): float
    {
        return $this->purchasePrice->value();
    }

    public function getBuyerName(): string
    {
        return $this->buyer->getName();
    }

    public function getBuyerEmail(): string
    {
        return $this->buyer->getEmail();
    }

    public function getPurchasedAt(): DateTimeImmutable
    {
        return $this->purchaseAt->value();
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->getId(),
            'product_id' => $this->getProductId(),
            'buyer_name' => $this->getBuyerName(),
            'buyer_email' => $this->getBuyerEmail(),
            'purchase_price' => $this->getPurchasePrice(),
            'purchased_at' => $this->getPurchasedAt()
        ];
    }

    public static function fromPrimitives(array $primitives): BackofficeProductPurchase
    {
        $buyer = BackofficeProductPurchaseBuyer::create($primitives['buyer_name'], $primitives['buyer_email']);

        return new BackofficeProductPurchase(
            BackofficeProductPurchaseId::create($primitives['id']),
            ProductId::create($primitives['product_id']),
            $buyer,
            BackofficeProductPurchasePrice::create($primitives['purchase_price']),
            BackofficeProductPurchaseDateTime::create($primitives['purchased_at'])
        );
    }

    public static function create(
        ProductId                         $productId,
        BackofficeProductPurchasePrice    $purchasePrice,
        BackofficeProductPurchaseBuyer    $buyer,
        BackofficeProductPurchaseDateTime $purchaseAt
    ): self
    {
        $purchase = new self(
            BackofficeProductPurchaseId::generate(),
            $productId,
            $purchasePrice,
            $buyer,
            $purchaseAt
        );

        $purchase->record(new ProductPurchaseCreated());

        return $purchase;
    }
}

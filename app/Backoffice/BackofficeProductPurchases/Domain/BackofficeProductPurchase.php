<?php

namespace App\Backoffice\BackofficeProductPurchases\Domain;


use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseBuyerEmail;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseBuyerName;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseDateTime;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseId;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchasePrice;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseQuantity;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseUnitPrice;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\Identifier\ProductId;
use App\Shared\Domain\Identifier\UserId;
use App\Shared\Domain\ValueObject\DateTimeValueObject;
use App\Store\ProductPurchases\Domain\Entity\BackofficeProductPurchaseBuyer;
use App\Store\ProductPurchases\Domain\Event\ProductPurchaseCreated;
use DateTimeImmutable;

class BackofficeProductPurchase extends AggregateRoot
{
    private readonly BackofficeProductPurchaseId $id;
    private readonly ProductId $productId;
    private readonly UserId $creatorId;
    private readonly BackofficeProductPurchaseBuyer $buyer;
    private readonly BackofficeProductPurchaseUnitPrice $unitPrice;
    private readonly BackofficeProductPurchaseQuantity $quantity;
    private readonly BackofficeProductPurchasePrice $price;
    private readonly DateTimeValueObject $purchaseAt;

    protected function __construct(
        BackofficeProductPurchaseId        $id,
        ProductId                          $productId,
        UserId $creatorId,
        BackofficeProductPurchaseUnitPrice $unitPrice,
        BackofficeProductPurchaseQuantity  $quantity,
        BackofficeProductPurchasePrice     $price,
        BackofficeProductPurchaseBuyer     $buyer,
        DateTimeValueObject                $purchaseAt,
    )
    {
        $this->id = $id;
        $this->productId = $productId;
        $this->creatorId = $creatorId;
        $this->buyer = $buyer;
        $this->unitPrice = $unitPrice;
        $this->quantity = $quantity;
        $this->price = $price;
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

    public function getCreatorId(): string
    {
        return $this->creatorId->value();
    }

    public function getUnitPrice(): string
    {
        return $this->unitPrice->value();
    }

    public function getPrice(): float
    {
        return $this->price->value();
    }

    public function getQuantity(): int
    {
        return $this->quantity->value();
    }

    public function getBuyerName(): string
    {
        return $this->buyer->getName();
    }

    public function getBuyerEmail(): string
    {
        return $this->buyer->getEmail();
    }

    public function getPurchasedAt(): int
    {
        return $this->purchaseAt->valueAsUnixTime();
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->getId(),
            'product_id' => $this->getProductId(),
            'creator_id' => $this->getCreatorId(),
            'buyer_name' => $this->getBuyerName(),
            'buyer_email' => $this->getBuyerEmail(),
            'unit_price' => $this->getUnitPrice(),
            'price' => $this->getPrice(),
            'quantity' => $this->getQuantity(),
            'purchased_at' => $this->getPurchasedAt()
        ];
    }

    public static function fromPrimitives(array $primitives): BackofficeProductPurchase
    {
        $buyerName = BackofficeProductPurchaseBuyerName::create($primitives['buyer_name']);
        $buyerEmail = BackofficeProductPurchaseBuyerEmail::create($primitives['buyer_email']);
        $buyer = BackofficeProductPurchaseBuyer::create($buyerName, $buyerEmail);

        return new BackofficeProductPurchase(
            id: BackofficeProductPurchaseId::create($primitives['id']),
            productId: ProductId::create($primitives['product_id']),
            creatorId: UserId::create($primitives['creator_id']),
            unitPrice: BackofficeProductPurchaseUnitPrice::create($primitives['unit_price']),
            quantity: BackofficeProductPurchaseQuantity::create($primitives['quantity']),
            price: BackofficeProductPurchasePrice::create($primitives['price']),
            buyer: $buyer,
            purchaseAt: DateTimeValueObject::createFromUnixTime($primitives['purchased_at'])
        );
    }

    public static function create(
        ProductId                          $productId,
        UserId                             $creatorId,
        BackofficeProductPurchaseUnitPrice $unitPrice,
        BackofficeProductPurchaseQuantity  $quantity,
        BackofficeProductPurchaseBuyer     $buyer,
    ): self
    {
        $price = BackofficeProductPurchasePrice::create(round($quantity->value() * $unitPrice->value(), 2));

        $purchase = new self(
            id: BackofficeProductPurchaseId::generate(),
            productId: $productId,
            creatorId: $creatorId,
            unitPrice: $unitPrice,
            quantity: $quantity,
            price: $price,
            buyer: $buyer,
            purchaseAt: DateTimeValueObject::create(new DateTimeImmutable()),
        );

        $purchase->record(new ProductPurchaseCreated());

        return $purchase;
    }
}

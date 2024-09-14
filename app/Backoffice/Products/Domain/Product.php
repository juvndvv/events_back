<?php

namespace App\Backoffice\Products\Domain;

use App\Backoffice\Products\Domain\Event\ProductCreatedEvent;
use App\Backoffice\Products\Domain\Event\ProductDeletedEvent;
use App\Backoffice\Products\Domain\ValueObject\ProductDescription;
use App\Backoffice\Products\Domain\ValueObject\ProductImage;
use App\Backoffice\Products\Domain\ValueObject\ProductName;
use App\Backoffice\Products\Domain\ValueObject\ProductPrice;
use App\Backoffice\Products\Domain\ValueObject\ProductTotalSales;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\Identifier\ProductId;
use App\Shared\Domain\Identifier\UserId;
use App\Shared\Domain\ValueObject\DateTimeValueObject;
use DateTimeImmutable;

class Product extends AggregateRoot
{
    private ?ProductId $id;
    private ?ProductName $name;
    private ?ProductPrice $price;
    private ?ProductDescription $description;
    private ?ProductImage $image;
    private ?ProductTotalSales $totalSales;

    private ?UserId $createdBy;
    private ?DateTimeValueObject $createdAt;
    private ?UserId $updatedBy;
    private ?DateTimeValueObject $updatedAt;
    private ?UserId $deletedBy;
    private ?DateTimeValueObject $deletedAt;

    protected function __construct(
        ?ProductId           $id = null,
        ?ProductName         $name = null,
        ?ProductDescription  $description = null,
        ?ProductImage        $image = null,
        ?ProductPrice        $price = null,
        ?ProductTotalSales   $totalSales = null,

        ?UserId              $createdBy = null,
        ?DateTimeValueObject $createdAt = null,
        ?UserId              $updatedBy = null,
        ?DateTimeValueObject $updatedAt = null,
        ?UserId              $deletedBy = null,
        ?DateTimeValueObject $deletedAt = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->image = $image;
        $this->price = $price;
        $this->totalSales = $totalSales;

        $this->createdBy = $createdBy;
        $this->createdAt = $createdAt;
        $this->updatedBy = $updatedBy;
        $this->updatedAt = $updatedAt;
        $this->deletedBy = $deletedBy;
        $this->deletedAt = $deletedAt;
    }

    public function getId(): string
    {
        return $this->id->value();
    }

    public function getName(): string
    {
        return $this->name->value();
    }

    public function getDescription(): string
    {
        return $this->description->value();
    }

    public function getImage(): string
    {
        return $this->image->value();
    }

    public function getPrice(): string
    {
        return $this->price->value();
    }

    public function getTotalSales(): int
    {
        return $this->totalSales->value();
    }

    public function getCreatedBy(): string
    {
        return $this->createdBy->value();
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt->valueAsUnixTime();
    }

    public function getUpdatedBy(): ?string
    {
        return $this->updatedBy?->value();
    }

    public function getUpdatedAt(): ?int
    {
        return $this->updatedAt?->valueAsUnixTime();
    }

    public function getDeletedBy(): ?string
    {
        return $this->deletedBy?->value();
    }

    public function getDeletedAt(): ?int
    {
        return $this->deletedAt?->valueAsUnixTime();
    }

    public function isDeleted(): bool
    {
        return $this->deletedAt->value() !== null;
    }

    public function delete(): void
    {
        $this->deletedAt = DateTimeValueObject::create(new DateTimeImmutable());
        $this->record(new ProductDeletedEvent());
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'image' => $this->getImage(),
            'price' => $this->getPrice(),
            'total_sales' => $this->getTotalSales(),
            'created_by' => $this->getCreatedBy(),
            'created_at' => $this->getCreatedAt(),
            'updated_by' => $this->getUpdatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'deleted_by' => $this->getDeletedBy(),
            'deleted_at' => $this->getDeletedAt(),
        ];
    }

    public static function fromPrimitives(array $primitives): Product
    {
        return new self(
            ProductId::create($primitives['id']),
            ProductName::create($primitives['name']),
            ProductDescription::create($primitives['description']),
            ProductImage::create($primitives['image']),
            ProductPrice::create($primitives['price']),
            ProductTotalSales::create($primitives['total_sales']),
            UserId::create($primitives['created_by']),
            DateTimeValueObject::createFromUnixTime($primitives['created_at']),
            UserId::create($primitives['updated_by']),
            DateTimeValueObject::createFromUnixTime($primitives['updated_at']),
            UserId::create($primitives['deleted_by']),
            DateTimeValueObject::createFromUnixTime($primitives['deleted_at']),
        );
    }

    public static function create(
        ProductName        $name,
        ProductDescription $description,
        ProductImage       $image,
        ProductPrice       $price,
        UserId             $createdBy
    ): self
    {
        $new = new self(
            id: ProductId::generate(),
            name: $name,
            description: $description,
            image: $image,
            price: $price,
            totalSales: ProductTotalSales::create(0),
            createdBy: $createdBy,
            createdAt: DateTimeValueObject::create(new DateTimeImmutable()),
        );

        $new->record(new ProductCreatedEvent());

        return $new;
    }
}

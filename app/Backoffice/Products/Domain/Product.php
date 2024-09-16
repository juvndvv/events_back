<?php

namespace App\Backoffice\Products\Domain;

use App\Backoffice\Products\Domain\Event\ProductCreated;
use App\Backoffice\Products\Domain\Event\ProductDeletedEvent;
use App\Backoffice\Products\Domain\Event\ProductDescriptionUpdatedEvent;
use App\Backoffice\Products\Domain\Event\ProductImageUpdatedEvent;
use App\Backoffice\Products\Domain\Event\ProductNameUpdatedEvent;
use App\Backoffice\Products\Domain\Event\ProductPriceUpdatedEvent;
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
        !$id ?: $this->id = $id;
        !$name ?: $this->name = $name;
        !$description ?: $this->description = $description;
        !$image ?: $this->image = $image;
        !$price ?: $this->price = $price;
        !$totalSales ?: $this->totalSales = $totalSales;

        !$createdBy ?: $this->createdBy = $createdBy;
        !$createdAt ?: $this->createdAt = $createdAt;
        !$updatedBy ?: $this->updatedBy = $updatedBy;
        !$updatedAt ?: $this->updatedAt = $updatedAt;
        !$deletedBy ?: $this->deletedBy = $deletedBy;
        !$deletedAt ?: $this->deletedAt = $deletedAt;
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
        if (!isset($this->updatedBy))
            return null;

        return $this->updatedBy->value();
    }

    public function getUpdatedAt(): ?int
    {
        if (!isset($this->updatedAt))
            return null;

        return $this->updatedAt->valueAsUnixTime();
    }

    public function getDeletedBy(): ?string
    {
        if (!isset($this->deletedBy))
            return null;

        return $this->deletedBy->value();
    }

    public function getDeletedAt(): ?int
    {
        if (!isset($this->deletedAt))
            return null;

        return $this->deletedAt->valueAsUnixTime();
    }

    public function updateName(string $name, string $updater): void
    {
        $this->name = ProductName::create($name);
        $this->record(new ProductNameUpdatedEvent());
        $this->update($updater);
    }

    public function updateDescription(string $description, string $updater): void
    {
        $this->description = ProductDescription::create($description);
        $this->record(new ProductDescriptionUpdatedEvent());
        $this->update($updater);
    }

    public function updateImage(string $image, string $updater): void
    {
        $this->image = ProductImage::create($image);
        $this->record(new ProductDescriptionUpdatedEvent());
        $this->update($updater);
    }

    public function updatePrice(float $price, string $updater): void
    {
        $this->price = ProductPrice::create($price);
        $this->record(new ProductPriceUpdatedEvent());
        $this->update($updater);
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
            'updated_by' => $this->getUpdatedBy(),
            'updated_at' => $this->getUpdatedAt(),
            'deleted_by' => $this->getDeletedBy(),
            'deleted_at' => $this->getDeletedAt(),
        ];
    }

    private function update(string $updater = null): void
    {
        $this->updatedAt = DateTimeValueObject::create(new DateTimeImmutable());
        $this->updatedBy = UserId::create($updater);
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
            $primitives['deleted_by'] ? UserId::create($primitives['deleted_by']) : null,
            $primitives['deleted_at'] ? DateTimeValueObject::createFromUnixTime($primitives['deleted_at']) : null,
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

        $new->record(new ProductCreated());

        return $new;
    }
}

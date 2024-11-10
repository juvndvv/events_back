<?php

namespace App\Backoffice\Products\Domain;

use App\Backoffice\Products\Domain\Event\ProductCreatedEvent;
use App\Backoffice\Products\Domain\ValueObject\OptionalProductDescription;
use App\Backoffice\Products\Domain\ValueObject\ProductDescription;
use App\Backoffice\Products\Domain\ValueObject\ProductName;
use App\Backoffice\Products\Domain\ValueObject\ProductTotalSales;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\ValueObject\Currency;
use App\Shared\Domain\ValueObject\DateTimeZoneValueObject;
use App\Shared\Domain\ValueObject\IntegerValueObject;
use App\Shared\Domain\ValueObject\ProductId;
use App\Shared\Domain\ValueObject\UserId;

class Product extends AggregateRoot
{
    private ProductId $id;
    private ProductName $name;
    private Currency $price;
    private OptionalProductDescription $description;
    private IntegerValueObject $totalSales;
    private UserId $creator;
    private DateTimeZoneValueObject $createdAt;

    protected function __construct(
        ProductId                  $id,
        ProductName                $name,
        OptionalProductDescription $description,
        Currency                   $price,
        ProductTotalSales          $totalSales,
        UserId                     $creator,
        DateTimeZoneValueObject    $createdAt,
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->totalSales = $totalSales;
        $this->creator = $creator;
        $this->createdAt = $createdAt;
    }

    public function id(): ProductId
    {
        return $this->id;
    }

    public function name(): ProductName
    {
        return $this->name;
    }

    public function updateName(ProductName $name): void
    {
        $this->name = $name;
    }

    public function description(): OptionalProductDescription
    {
        return $this->description;
    }

    public function updateDescription(OptionalProductDescription $description): void
    {
        $this->description = $description;
    }

    public function price(): Currency
    {
        return $this->price;
    }

    public function updatePrice(Currency $price): void
    {
        $this->price = $price;
    }

    public function getTotalSales(): IntegerValueObject
    {
        return $this->totalSales;
    }

    public function creatorId(): UserId
    {
        return $this->creator;
    }


    public function createdAt(): DateTimeZoneValueObject
    {
        return $this->createdAt;
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id()->value(),
            'name' => $this->name()->value(),
            'description' => $this->description()->orElseNull(),
            'price' => $this->price()->amount(),
            'total_sales' => $this->getTotalSales()->value(),
            'created_by' => $this->creatorId()->value(),
            'created_at' => $this->createdAt()->toUtc(),
        ];
    }

    public static function fromPrimitives(array $primitives): Product
    {
        return new self(
            id: ProductId::create($primitives['id']),
            name: ProductName::create($primitives['name']),
            description: OptionalProductDescription::ofNullableWith($primitives['description'], fn() => ProductDescription::create($primitives['description'])),
            price: Currency::createFromString($primitives['price']),
            totalSales: ProductTotalSales::create($primitives['total_sales']),
            creator: UserId::create($primitives['created_by']),
            createdAt: DateTimeZoneValueObject::fromUtc($primitives['created_at']),
        );
    }

    public static function create(
        ProductId                  $id,
        ProductName                $name,
        OptionalProductDescription $description,
        Currency                   $price,
        UserId                     $creatorId
    ): self
    {
        $new = new self(
            id: $id,
            name: $name,
            description: $description,
            price: $price,
            totalSales: ProductTotalSales::create(0),
            creator: $creatorId,
            createdAt: DateTimeZoneValueObject::now()
        );

        $new->record(new ProductCreatedEvent());

        return $new;
    }
}

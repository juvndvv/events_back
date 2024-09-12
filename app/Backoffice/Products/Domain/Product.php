<?php

namespace App\Backoffice\Products\Domain;

use App\Backoffice\Products\Domain\Event\ProductCreatedEvent;
use App\Backoffice\Products\Domain\ValueObject\ProductDescription;
use App\Backoffice\Products\Domain\ValueObject\ProductImage;
use App\Backoffice\Products\Domain\ValueObject\ProductName;
use App\Backoffice\Products\Domain\ValueObject\ProductPrice;
use App\Backoffice\Products\Domain\ValueObject\ProductTotalSales;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\Identifier\ProductId;
use App\Shared\Domain\Identifier\UserId;

class Product extends AggregateRoot
{
    private readonly ?ProductId $id;
    private readonly ?ProductName $name;
    private readonly ?ProductPrice $price;
    private readonly ?ProductDescription $description;
    private readonly ?ProductImage $image;
    private readonly ?ProductTotalSales $totalSales;
    private readonly ?UserId $creator;

    protected function __construct(
        ?ProductId          $id = null,
        ?ProductName        $name = null,
        ?ProductDescription $description = null,
        ?ProductImage       $image = null,
        ?ProductPrice       $price = null,
        ?ProductTotalSales  $totalSales = null,
        ?UserId             $creatorId = null,
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->image = $image;
        $this->price = $price;
        $this->totalSales = $totalSales;
        $this->creator = $creatorId;
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

    public function getCreatorId()
    {
        return $this->creator->value();
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
            'creator_id' => $this->getCreatorId(),
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
            UserId::create($primitives['creator_id']),
        );
    }

    public static function create(
        ProductName $name,
        ProductDescription $description,
        ProductImage $image,
        ProductPrice $price,
        UserId $creatorId
    ): self {
        $new = new self(
            id: ProductId::generate(),
            name: $name,
            description: $description,
            image: $image,
            price: $price,
            totalSales: ProductTotalSales::create(0),
            creatorId: $creatorId,
        );

        $new->record(new ProductCreatedEvent());

        return $new;
    }
}

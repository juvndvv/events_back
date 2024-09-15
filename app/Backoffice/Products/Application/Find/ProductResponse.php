<?php

namespace App\Backoffice\Products\Application\Find;

use App\Backoffice\Products\Domain\Product;

class ProductResponse
{
    private function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $description,
        private readonly string $image,
        private readonly float $price,
        private readonly int $totalSales,
        private readonly int $createdAt,
        private readonly ?int $updatedAt,
        private readonly ?int $deletedAt,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'price' => $this->price,
            'total_sales' => $this->totalSales,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'deleted_at' => $this->deletedAt,
        ];
    }

    public static function create(Product $product): self
    {
        return new self(
            id: $product->getId(),
            name: $product->getName(),
            description: $product->getDescription(),
            image: $product->getImage(),
            price: $product->getPrice(),
            totalSales: $product->getTotalSales(),
            createdAt: $product->getCreatedAt(),
            updatedAt: $product->getUpdatedAt(),
            deletedAt: $product->getDeletedAt(),
        );
    }
}

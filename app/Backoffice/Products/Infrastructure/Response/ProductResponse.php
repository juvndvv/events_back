<?php

declare(strict_types=1);

namespace App\Backoffice\Products\Infrastructure\Response;


class ProductResponse
{
    private function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly float $price,
        public readonly int $totalSales,
        public readonly string $creatorId,
        public readonly string $creatorName,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'totalSales' => $this->totalSales,
            'user' => [
                'id' => $this->creatorId,
                'name' => $this->creatorName,
            ],
        ];
    }

    public static function create(
        string $id,
        string $name,
        ?string $description,
        float $price,
        int $totalSales,
        string $creatorId,
        string $creatorName,
    )
    {
        return new self(
            id: $id,
            name: $name,
            description: $description,
            price: $price,
            totalSales: $totalSales,
            creatorId: $creatorId,
            creatorName: $creatorName
        );
    }
}

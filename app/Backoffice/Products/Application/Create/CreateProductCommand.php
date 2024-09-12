<?php

namespace App\Backoffice\Products\Application\Create;

class CreateProductCommand
{
    private function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly string $image,
        public readonly float $price,
        public readonly string $creatorId,
    )
    {
    }

    public static function create(
        string $name,
        string $description,
        string $image,
        float $price,
        string $creatorId,
    ): self
    {
        return new self($name, $description, $image, $price, $creatorId);
    }
}

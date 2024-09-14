<?php

namespace App\Backoffice\Products\Application\Update;

class UpdateProductCommand
{
    private function __construct(
        public string $activeUserId,
        public string $id,
        public ?string $name,
        public ?string $description,
        public ?float $price,
        public ?string $image,
    )
    {
    }

    public static function create(
        string $activeUserId,
        string $id,
        ?string $name,
        ?string $description,
        ?float $price,
        ?string $image
    ): self
    {
        return new self($activeUserId, $id, $name, $description, $price, $image);
    }
}

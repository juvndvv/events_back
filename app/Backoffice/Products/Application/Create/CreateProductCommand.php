<?php

namespace App\Backoffice\Products\Application\Create;

class CreateProductCommand
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly string $image,
        public readonly float $price,
        public readonly string $creatorId,
    )
    {
    }
}

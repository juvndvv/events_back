<?php

namespace App\Backoffice\BackofficeProductPurchases\Application\Create;

class CreateBackofficeProductPurchaseCommand
{
    private function __construct(
        public readonly string $productId,
        public readonly string $creatorId,
        public readonly int $quantity,
        public readonly string $name,
        public readonly string $email,
    )
    {
    }

    public static function create(
        string $productId,
        string $creatorId,
        int $quantity,
        string $name,
        string $email,
    ): self {
        return new self($productId, $creatorId, $quantity, $name, $email);
    }
}

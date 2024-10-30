<?php

namespace App\Backoffice\Products\Application\Delete;

use App\Shared\Domain\ValueObject\ProductId;
use App\Shared\Domain\ValueObject\UserId;

readonly class DeleteProductCommand
{
    private function __construct(
        public ProductId $id,
        public UserId $deleterId
    )
    {
    }

    public static function create(
        string $id,
        string $deleterId
    ): self {
        return new self(
            ProductId::create($id),
            UserId::create($deleterId)
        );
    }
}

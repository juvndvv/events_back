<?php

namespace App\Backoffice\Products\Application\Delete;

class DeleteProductCommand
{
    private function __construct(
        public readonly string $id,
        public readonly string $deleterId
    )
    {
    }

    public static function create(
        string $id,
        string $deleterId
    ): self {
        return new self($id, $deleterId);
    }
}

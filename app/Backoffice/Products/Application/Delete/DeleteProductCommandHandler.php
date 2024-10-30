<?php

namespace App\Backoffice\Products\Application\Delete;

use App\Backoffice\Products\Domain\Service\ProductRemover;

readonly class DeleteProductCommandHandler
{
    public function __construct(
        private ProductRemover $productRemover
    )
    {
    }

    public function __invoke(DeleteProductCommand $command): void
    {
        $product = $this->productRemover->removeById($command->id);
        // TODO publish domain event
    }
}

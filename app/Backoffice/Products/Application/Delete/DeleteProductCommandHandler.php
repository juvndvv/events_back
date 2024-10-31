<?php

namespace App\Backoffice\Products\Application\Delete;

use App\Backoffice\Products\Application\Service\ProductRemover;

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
    }
}

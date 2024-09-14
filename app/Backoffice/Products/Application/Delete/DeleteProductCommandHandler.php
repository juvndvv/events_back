<?php

namespace App\Backoffice\Products\Application\Delete;

use App\Backoffice\Products\Domain\Service\ProductRemover;

class DeleteProductCommandHandler
{
    public function __construct(
        private readonly ProductRemover $productRemover
    )
    {
    }

    public function __invoke(DeleteProductCommand $command): void
    {
        $this->productRemover->__invoke($command->id);
        // TODO publish domain event
    }
}

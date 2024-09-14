<?php

namespace App\Backoffice\Products\Application\Update;

use App\Backoffice\Products\Domain\Service\ProductUpdater;

class UpdateProductCommandHandler
{
    public function __construct(
        private readonly ProductUpdater $productUpdater
    )
    {
    }

    public function __invoke(UpdateProductCommand $command): void
    {
        $this->productUpdater->__invoke(
            updater: $command->activeUserId,
            id: $command->id,
            name: $command->name,
            description: $command->description,
            price: $command->price,
            image: $command->image,
        );
    }
}

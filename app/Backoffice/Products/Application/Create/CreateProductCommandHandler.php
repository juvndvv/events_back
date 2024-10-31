<?php

namespace App\Backoffice\Products\Application\Create;

use App\Backoffice\Products\Application\Service\ProductCreator;
use App\Shared\Domain\Service\Validator\Validator;

readonly class CreateProductCommandHandler
{
    public function __construct(
        private Validator $validator,
        private ProductCreator $productCreator
    )
    {
    }

    public function __invoke(CreateProductCommand $command): void
    {
        $this->validator->validateOrFail($command);

        $this->productCreator->create(
            id: $command->id(),
            name: $command->name(),
            description: $command->description(),
            price: $command->price(),
            creatorId: $command->creatorId()
        );
    }
}

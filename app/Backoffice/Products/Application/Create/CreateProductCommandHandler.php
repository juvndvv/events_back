<?php

namespace App\Backoffice\Products\Application\Create;

use App\Backoffice\Products\Domain\Service\ProductCreator;
use App\Backoffice\Products\Domain\ValueObject\ProductDescription;
use App\Backoffice\Products\Domain\ValueObject\ProductImage;
use App\Backoffice\Products\Domain\ValueObject\ProductName;
use App\Backoffice\Products\Domain\ValueObject\ProductPrice;
use App\Shared\Domain\Identifier\UserId;

class CreateProductCommandHandler
{
    public function __construct(
        private readonly ProductCreator $productCreator
    )
    {
    }

    public function __invoke(CreateProductCommand $command): void
    {
        $product = $this->productCreator->__invoke(
            name: ProductName::create($command->name),
            description: ProductDescription::create($command->description),
            image: ProductImage::create($command->image),
            price: ProductPrice::create($command->price),
            creatorId: UserId::create($command->creatorId)
        );
        // TODO publish domain event
    }
}

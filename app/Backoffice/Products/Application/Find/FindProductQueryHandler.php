<?php

namespace App\Backoffice\Products\Application\Find;

use App\Backoffice\Products\Domain\Exceptions\ProductDoesntExist;
use App\Backoffice\Products\Domain\Service\ProductFinder;

class FindProductQueryHandler
{
    public function __construct(
        private readonly ProductFinder $finder,
    )
    {
    }

    public function __invoke(FindProductQuery $query): ProductResponse
    {
        $product = $this->finder->__invoke($query->id);

        if (null === $product) {
            throw new ProductDoesntExist($query->id);
        }

        return ProductResponse::create($product);
    }
}

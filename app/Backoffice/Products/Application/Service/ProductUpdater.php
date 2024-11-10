<?php

declare(strict_types=1);

namespace App\Backoffice\Products\Application\Service;


use App\Backoffice\Products\Domain\Port\ProductRepository;
use App\Backoffice\Products\Domain\Product;
use App\Backoffice\Products\Domain\ValueObject\OptionalProductDescription;
use App\Backoffice\Products\Domain\ValueObject\OptionalProductName;
use App\Shared\Domain\ValueObject\OptionalCurrency;

readonly class ProductUpdater
{
    public function __construct(
        private ProductRepository $repository
    )
    {
    }

    public function update(
        Product $product,
        OptionalProductName $name,
        OptionalProductDescription $decription,
        OptionalCurrency $currency,
    )
    {
        $name->ifPresent(fn () => $product->updateName($name->get()));
        $decription->ifPresent(fn () => $product->updateDescription($decription->get()));
        $currency->ifPresent(fn () => $product->updatePrice($currency->get()));

        $this->repository->save($product);
    }
}

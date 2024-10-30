<?php

declare(strict_types=1);

namespace Tests\Backoffice\Products\Domain\ValueObject;


use App\Backoffice\Products\Domain\ValueObject\OptionalProductDescription;
use App\Backoffice\Products\Domain\ValueObject\ProductDescription;

class ProductDescriptionMother extends ProductDescription
{
    public static function random(): OptionalProductDescription
    {
        if (rand(0, 1) === 0) {
            return OptionalProductDescription::empty();
        }

        return OptionalProductDescription::ofNullable(new ProductDescription(uniqid('product-description', true)));
    }
}

<?php

declare(strict_types=1);

namespace App\Backoffice\Products\Application\Update;


use App\Backoffice\Products\Domain\ValueObject\OptionalProductDescription;
use App\Backoffice\Products\Domain\ValueObject\OptionalProductName;
use App\Backoffice\Products\Domain\ValueObject\ProductName;
use App\Shared\Domain\ValueObject\Currency;
use App\Shared\Domain\ValueObject\OptionalCurrency;
use App\Shared\Domain\ValueObject\ProductId;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Uuid;

readonly class UpdateProductCommand
{
    private function __construct(

        #[Uuid]
        private ?string $id,

        #[Length(min: 3, max: 50)]
        private ?string $name,

        #[Length(min: 3, max: 1200)]
        private ?string $description,

        private ?string $price,
    )
    {
    }

    public function id(): ProductId
    {
        return ProductId::create($this->id);
    }

    public function name(): OptionalProductName
    {
        return OptionalProductName::ofNullableWith($this->name, fn ($name) => ProductName::create($name));
    }

    public function description(): OptionalProductDescription
    {
        return OptionalProductDescription::ofNullable($this->description);
    }

    public function price(): OptionalCurrency
    {
        return OptionalCurrency::ofNullableWith($this->price, fn ($price) => Currency::createFromString($price));
    }

    public static function create(
        ?string $id,
        ?string $name,
        ?string $description,
        ?float  $price,
    ): self
    {
        return new self (
            id: $id,
            name: $name,
            description: $description,
            price: $price,
        );
    }
}

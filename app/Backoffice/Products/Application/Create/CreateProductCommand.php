<?php

namespace App\Backoffice\Products\Application\Create;

use App\Backoffice\Products\Domain\ValueObject\OptionalProductDescription;
use App\Backoffice\Products\Domain\ValueObject\OptionalProductId;
use App\Backoffice\Products\Domain\ValueObject\OptionalProductName;
use App\Backoffice\Products\Domain\ValueObject\ProductDescription;
use App\Backoffice\Products\Domain\ValueObject\ProductName;
use App\Shared\Domain\ValueObject\Currency;
use App\Shared\Domain\ValueObject\OptionalCurrency;
use App\Shared\Domain\ValueObject\OptionalUserId;
use App\Shared\Domain\ValueObject\ProductId;
use App\Shared\Domain\ValueObject\UserId;

readonly class CreateProductCommand
{
    private function __construct(
        private OptionalProductId          $id,
        private OptionalProductName        $name,
        private OptionalProductDescription $description,
        private OptionalCurrency           $price,
        private OptionalUserId             $creatorId,
    )
    {
    }

    public function id(): ProductId
    {
        return $this->id->get();
    }

    public function name(): ProductName
    {
        return $this->name->get();
    }

    public function description(): OptionalProductDescription
    {
        return $this->description;
    }

    public function price(): Currency
    {
        return $this->price->get();
    }

    public function creatorId(): UserId
    {
        return $this->creatorId->get();
    }

    public static function create(
        ?string $id,
        ?string $name,
        ?string $description,
        ?float  $price,
        ?string $creatorId,
    ): self
    {
        return new self (
            id: OptionalProductId::ofNullableWith($id, fn($id) => ProductId::create($id)),
            name: OptionalProductName::ofNullableWith($name, fn($name) => ProductName::create($name)),
            description: OptionalProductDescription::ofNullableWith($description, fn($description) => ProductDescription::create($description)),
            price: OptionalCurrency::ofNullableWith($price, fn($price) => Currency::createFromString($price)),
            creatorId: OptionalUserId::ofNullableWith($creatorId, fn($creatorId) => UserId::create($creatorId)),
        );

    }
}

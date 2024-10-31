<?php

namespace App\Backoffice\Products\Application\Create;

use App\Backoffice\Products\Domain\ValueObject\OptionalProductDescription;
use App\Backoffice\Products\Domain\ValueObject\ProductName;
use App\Shared\Domain\ValueObject\Currency;
use App\Shared\Domain\ValueObject\ProductId;
use App\Shared\Domain\ValueObject\UserId;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Uuid;

readonly class CreateProductCommand
{
    private function __construct(

        #[Uuid]
        #[NotBlank]
        private ?string $id,

        #[NotBlank]
        #[Length(min: 3, max: 50)]
        private ?string $name,

        #[Length(min: 3, max: 1200)]
        private ?string $description,

        private ?string $price,

        #[Uuid]
        #[NotBlank]
        private ?string $creatorId,
    )
    {
    }

    public function id(): ProductId
    {
        return ProductId::create($this->id);
    }

    public function name(): ProductName
    {
        return ProductName::create($this->name);
    }

    public function description(): OptionalProductDescription
    {
        return OptionalProductDescription::ofNullable($this->description);
    }

    public function price(): Currency
    {
        return Currency::createFromString($this->price);
    }

    public function creatorId(): UserId
    {
        return UserId::create($this->creatorId);
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
            id: $id,
            name: $name,
            description: $description,
            price: $price,
            creatorId: $creatorId
        );
    }
}

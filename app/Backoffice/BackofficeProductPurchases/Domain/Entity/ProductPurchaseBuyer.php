<?php

namespace App\Backoffice\BackofficeProductPurchases\Domain\Entity;


use App\Store\ProductPurchases\Domain\ValueObject\ProductPurchaseBuyerEmail;
use App\Store\ProductPurchases\Domain\ValueObject\ProductPurchaseBuyerName;

class ProductPurchaseBuyer
{
    private ProductPurchaseBuyerName $name;
    private ProductPurchaseBuyerEmail $email;

    private function __construct(
        ProductPurchaseBuyerName $name,
        ProductPurchaseBuyerEmail $email,
    )
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->name->value();
    }

    public function getEmail(): string
    {
        return $this->email->value();
    }

    public static function create(string $name, string $email): self
    {
        return new self(
            ProductPurchaseBuyerName::create($name),
            ProductPurchaseBuyerEmail::create($email)
        );
    }
}

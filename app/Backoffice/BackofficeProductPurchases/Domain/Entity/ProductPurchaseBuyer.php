<?php

namespace App\Backoffice\BackofficeProductPurchases\Domain\Entity;


use App\Store\ProductPurchases\Domain\ValueObject\BackofficeProductPurchaseBuyerEmail;
use App\Store\ProductPurchases\Domain\ValueObject\BackofficeProductPurchaseBuyerName;

class ProductPurchaseBuyer
{
    private BackofficeProductPurchaseBuyerName $name;
    private BackofficeProductPurchaseBuyerEmail $email;

    private function __construct(
        BackofficeProductPurchaseBuyerName  $name,
        BackofficeProductPurchaseBuyerEmail $email,
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
            BackofficeProductPurchaseBuyerName::create($name),
            BackofficeProductPurchaseBuyerEmail::create($email)
        );
    }
}

<?php

namespace App\Backoffice\BackofficeProductPurchases\Domain\Entity;



use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseBuyerEmail;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseBuyerName;

class BackofficeProductPurchaseBuyer
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

    public static function create(BackofficeProductPurchaseBuyerName $name, BackofficeProductPurchaseBuyerEmail $email): self
    {
        return new self(
            $name, $email
        );
    }
}

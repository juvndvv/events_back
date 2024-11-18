<?php

declare(strict_types=1);

namespace App\Admin\Customer\Domain;


use App\Shared\Domain\Utils\Optional;

/**
 * @extends Optional<Customer>
 */
class OptionalCustomer extends Optional
{
    public function getType(): string
    {
        return Customer::class;
    }
}

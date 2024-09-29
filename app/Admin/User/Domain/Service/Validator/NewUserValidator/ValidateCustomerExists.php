<?php

namespace App\Admin\User\Domain\Service\Validator\NewUserValidator;

use App\Admin\Customer\Application\Service\CustomerFinder;
use App\Admin\User\Domain\Service\Validator\UserValidator;

class ValidateCustomerExists implements UserValidator
{
    public function __construct(
        private readonly CustomerFinder $finder,
    )
    {
    }

    public function validate(string $customerId, string $name, string $email, string $password, array &$bag): void
    {
            $customer = $this->finder->searchById($customerId);

            if (null === $customer) {
                $bag['customer_id'] = 'El cliente no existe';
            }
    }
}

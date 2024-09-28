<?php

namespace App\Admin\Customer\Application\Create;

use App\Shared\Application\Response;

class CreateCustomerResponse extends Response
{
    public function __construct(
        private readonly string $id
    )
    {
    }

    public function response(): array
    {
        return [
            'id' => $this->id,
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Admin\Customer\Application\Create;


use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Uuid;

class CreateCustomerCommand
{
    protected function __construct(

        #[Uuid]
        #[NotBlank]
        public readonly string $id,

        #[NotBlank]
        public readonly string $name,
    )
    {
    }

    public static function create(
        string $id,
        string $name,
    ): self {
        return new self(
            id: $id,
            name: $name,
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Backoffice\Products\Application\Update;


use App\Shared\Domain\Service\Validator\Validator;

readonly class UpdateProductCommandHandler
{
    public function __construct(
        private Validator $validator
    )
    {
    }

    public function __invoke(UpdateProductCommand $command): void
    {
        $this->validator->validateOrFail($command);
    }
}

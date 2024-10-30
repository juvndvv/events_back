<?php

declare (strict_types=1);

namespace App\Shared\Domain\Service\Validator;


interface Validator
{
    public function validate(mixed $value): self;
    public function getErrorBag(): array;
    public function hasErrors(): bool;
    public function validateOrFail(mixed $value): void;
}

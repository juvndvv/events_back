<?php

declare(strict_types=1);

namespace App\Shared\Domain\Service\Validator;


use App\Shared\Domain\Exception\LogicException;
use App\Shared\Domain\Exception\ValidationException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SymfonyValidator implements Validator
{
    private array $errorBag;

    public function __construct(
        private readonly ValidatorInterface $symfonyValidator,
    )
    {
    }

    public function validate(mixed $value): self
    {
        $violations = $this->symfonyValidator->validate($value);
        $this->errorBag = $this->violationsToArray($violations);
        return $this;
    }

    public function validateOrFail(mixed $value): void
    {
        if ($this->validate($value)->hasErrors()) {
            throw new ValidationException($this->errorBag);
        }
    }

    public function hasErrors(): bool
    {
        if (!isset($this->errorBag)) {
            throw new LogicException('You must call validate() method before calling this hasErrors() method');
        }

        return !empty($this->errorBag);
    }

    public function getErrorBag(): array
    {
        return $this->errorBag;
    }

    private function violationsToArray(ConstraintViolationListInterface $violations): array
    {
        $errores = [];

        foreach ($violations as $violation) {
            $property = $violation->getPropertyPath();
            $errores[$property][] = $violation->getMessage();
        }

        return $errores;
    }
}

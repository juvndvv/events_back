<?php

namespace App\Backoffice\User\Domain\Exception;

class DuplicatedUserEmail extends \Exception
{
    public function __construct(string $email, int $code = 0, ?Throwable $previous = null)
    {
        $message = "The email '{$email}' already exists.";
        parent::__construct($message, $code, $previous);
    }
}

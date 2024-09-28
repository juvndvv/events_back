<?php

namespace App\Admin\User\Domain\Exception;

class UserDoesntExist extends \Exception
{
    public function __construct(string $id, int $code = 0, ?Throwable $previous = null)
    {
        $message = "User doesn't exist with id {$id}";
        parent::__construct($message, $code, $previous);
    }
}

<?php

namespace App\Admin\User\Domain\Exception;

use Throwable;

class UserAlreadyExist extends \Exception
{
    public function __construct(string $id, int $code = 0, ?Throwable $previous = null)
    {
        $message = sprintf('User with id "%s" already exist.', $id);
        parent::__construct($message, $code, $previous);
    }
}

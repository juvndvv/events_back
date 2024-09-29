<?php

namespace App\Admin\User\Domain\Exception;

use App\Admin\User\Domain\User;
use Exception;
use Throwable;

class UserAlreadyActivated extends Exception
{
    public function __construct(User $user, int $code = 0, ?Throwable $previous = null)
    {
        $mesage = sprintf("%s [%s] already activated", $user->getName(), $user->getId());
        parent::__construct($mesage, $code, $previous);
    }
}

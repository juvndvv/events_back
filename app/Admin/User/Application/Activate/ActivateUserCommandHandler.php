<?php

namespace App\Admin\User\Application\Activate;

use App\Admin\User\Application\Service\UserFinder;
use App\Admin\User\Domain\Exception\UserDoesntExist;

class ActivateUserCommandHandler
{
    public function __construct(
        protected readonly UserFinder $finder
    )
    {
    }

    public function __invoke(ActivateUserCommand $command): void
    {
        $user = $this->finder->findById($command->id);

        if (null === $user) {
            throw new UserDoesntExist($command->id);
        }

        $user->activate();
    }
}

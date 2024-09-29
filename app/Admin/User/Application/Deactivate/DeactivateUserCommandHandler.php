<?php

namespace App\Admin\User\Application\Deactivate;

use App\Admin\User\Application\Service\UserFinder;
use App\Admin\User\Domain\Exception\UserDoesntExist;

class DeactivateUserCommandHandler
{
    public function __construct(
        protected readonly UserFinder $finder
    )
    {
    }

    public function __invoke(DeactivateUserCommand $command): void
    {
        $user = $this->finder->findById($command->id);

        if (null === $user) {
            throw new UserDoesntExist($command->id);
        }

        $user->deactivate();
    }
}

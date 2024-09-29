<?php

namespace App\Admin\User\Application\Find;

use App\Admin\User\Application\Service\UserFinder;
use App\Admin\User\Domain\Exception\UserDoesntExist;

class FindUserQueryHandler
{
    public function __construct(
        private readonly UserFinder $finder,
    )
    {
    }

    public function __invoke(FindUserQuery $query): FindUserResponse
    {
        $user = $this->finder->findById($query->id);

        if (null === $user) {
            throw new UserDoesntExist($query->id);
        }

        return new FindUserResponse($user);
    }
}

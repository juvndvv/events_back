<?php

namespace App\Admin\User\Application\Find;

class FindUserQuery
{
    public function __construct(
        public readonly string $id,
    )
    {
    }
}

<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;


use App\Shared\Domain\Utils\Optional;

/**
 * @extends Optional<UserId>
 */
class OptionalUserId extends Optional
{
    public function getType(): string
    {
        return UserId::class;
    }
}

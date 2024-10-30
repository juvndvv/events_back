<?php

namespace Tests\Shared\Domain\ValueObject;


use App\Shared\Domain\ValueObject\UuidValueObject;

class UuidValueObjectMother extends UuidValueObject
{
    public function random(): UuidValueObject
    {
        return UuidValueObject::generate();
    }
}

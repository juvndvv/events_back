<?php

namespace App\Backoffice\Products\Application\Find;

class FindProductQuery
{
    public function __construct(
        public readonly string $id,
    )
    {
    }

    public static function create(
        string $id,
    )
    {
        return new self($id);
    }
}

<?php

namespace App\Backoffice\Products\Domain\Port;


use App\Backoffice\Products\Domain\Product;

interface ProductRepository
{
    public function save(Product $product): void;

    public function search(string $id): ?Product;
}

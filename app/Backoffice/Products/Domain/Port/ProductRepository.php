<?php

namespace App\Backoffice\Products\Domain\Port;


use App\Backoffice\Products\Domain\OptionalProduct;
use App\Backoffice\Products\Domain\Product;
use App\Shared\Domain\ValueObject\ProductId;

interface ProductRepository
{
    public function save(Product $product): void;
    public function search(ProductId $id): OptionalProduct;
    public function delete(Product $product): void;
}

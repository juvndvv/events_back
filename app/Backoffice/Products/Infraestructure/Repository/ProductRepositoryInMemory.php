<?php

namespace App\Backoffice\Product\Infraestructure\Repository;


use App\Backoffice\Products\Domain\Port\ProductRepository;
use App\Backoffice\Products\Domain\Product;

final class ProductRepositoryInMemory implements ProductRepository
{
    private static $products = [];

    public function save(Product $product): void
    {
        self::$products[] = $product;
    }

    public function search(string $id): ?Product
    {
        foreach (self::$products as $product) {
            if ($product->getId() === $id) {
                return $product;
            }
        }

        return null;
    }

    public function delete(Product $product): void
    {
        self::$products = array_filter(self::$products, function (Product $p) use ($product) {
            return $p->getId() !== $product->getId();
        });
    }
}

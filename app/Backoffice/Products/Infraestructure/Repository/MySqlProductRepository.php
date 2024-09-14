<?php

namespace App\Backoffice\Products\Infraestructure\Repository;

use App\Backoffice\Products\Domain\Port\ProductRepository;
use App\Backoffice\Products\Domain\Product;
use Illuminate\Support\Facades\DB;

final class MySqlProductRepository implements ProductRepository
{
    public function save(Product $product): void
    {
        DB::table('products')
            ->create([
                'id' => $product->getId(),
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'image' => $product->getImage(),
                'price' => $product->getPrice(),
                'total_sales' => $product->getTotalSales(),
                'created_by' => $product->getCreatedBy(),
                'created_at' => $product->getCreatedAt(),
                'updated_by' => $product->getUpdatedBy(),
                'updated_at' => $product->getUpdatedAt(),
                'deleted_by' => $product->getDeletedBy(),
                'deleted_at' => $product->getDeletedAt(),
            ]);
    }

    public function search(string $id): ?Product
    {
        $db = DB::table('products')
            ->where('id', $id)
            ->first();

        if (null == $db) {
            return null;
        }

        $primitives = [
            'id' => $db->id,
            'name' => $db->name,
            'description' => $db->description,
            'image' => $db->image,
            'price' => $db->price,
            'total_sales' => $db->total_sales,
            'created_by' => $db->created_by,
            'created_at' => $db->created_at,
            'updated_by' => $db->updated_by,
            'updated_at' => $db->updated_at,
            'deleted_by' => $db->deleted_by,
            'deleted_at' => $db->deleted_at,
        ];

        return Product::fromPrimitives($primitives);
    }

    public function delete(Product $product): void
    {
        DB::table('products')
            ->where('id', $product->getId())
            ->delete();
    }
}

<?php

namespace Tests\Backoffice\Products\Infrastructure\Repository;

use App\Backoffice\Products\Infraestructure\Repository\MySqlProductRepository;
use PHPUnit\Framework\Attributes\Group;
use Tests\DbTestCase;
use Tests\Stub\ProductMother;

#[Group('infrastructure')]
class MySqlProductRepositoryTest extends DbTestCase
{
    private MySqlProductRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new MySqlProductRepository();
    }

    public function testItShouldSave(): void
    {
        $product = ProductMother::son();

        $this->repository->save($product);

        $this->assertDatabaseHas('products', [
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

    public function testItShouldDelete(): void
    {
        $product = ProductMother::son();

        $this->repository->save($product);

        $this->repository->delete($product);

        $this->assertDatabaseMissing('products', $product->toPrimitives());
    }

    public function testItShouldReturnNullOnSearch(): void
    {
        $result = $this->repository->search(ProductMother::son()->getId());
        $this->assertNull($result);
    }

    public function testItShouldReturnProductOnSearch(): void
    {
        $product = ProductMother::son();
        $this->repository->save($product);

        $result = $this->repository->search($product->getId());

        $this->assertEquals($product->getId(), $result->getId());
        $this->assertEquals($product->getName(), $result->getName());
        $this->assertEquals($product->getDescription(), $result->getDescription());
        $this->assertEquals($product->getImage(), $result->getImage());
        $this->assertEquals($product->getPrice(), $result->getPrice());
        $this->assertEquals($product->getTotalSales(), $result->getTotalSales());
        $this->assertEquals($product->getCreatedBy(), $result->getCreatedBy());
        $this->assertEquals($product->getCreatedAt(), $result->getCreatedAt());
        $this->assertEquals($product->getUpdatedBy(), $result->getUpdatedBy());
        $this->assertEquals($product->getUpdatedAt(), $result->getUpdatedAt());
        $this->assertEquals($product->getDeletedBy(), $result->getDeletedBy());
        $this->assertEquals($product->getDeletedAt(), $result->getDeletedAt());
    }

    public function testItShouldUpdateProduct()
    {
        $product = ProductMother::son();
        $updatedProduct = ProductMother::son(id: $product->getId());

        $this->repository->save($product);
        $this->repository->update($updatedProduct);

        $this->assertDatabaseHas('products', $updatedProduct->toPrimitives());
    }
}

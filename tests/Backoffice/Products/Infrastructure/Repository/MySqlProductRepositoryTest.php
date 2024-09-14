<?php

namespace Tests\Backoffice\Products\Infrastructure\Repository;

use App\Backoffice\Products\Infraestructure\Repository\MySqlProductRepository;
use Illuminate\Support\Facades\DB;
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

        $this->assertDatabaseHas('products', $product->toPrimitives());
    }

    public function testItShouldDelete(): void
    {
        $product = ProductMother::son();

        DB::table('products')->insert($product->toPrimitives());

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

        DB::table('products')->insert($product->toPrimitives());

        $result = $this->repository->search($product->getId());

        $this->assertEquals($product->toPrimitives(), $result->toPrimitives());
    }

    public function testItShouldUpdateProduct()
    {
        $product = ProductMother::son();
        $updatedProduct = ProductMother::son(id: $product->getId());

        DB::table('products')->insert($product->toPrimitives());

        $this->repository->update($updatedProduct);

        $this->assertDatabaseHas('products', $updatedProduct->toPrimitives());
    }
}

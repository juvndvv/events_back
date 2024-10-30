<?php

namespace Tests\Backoffice\Products\Domain\Service;

use App\Backoffice\Products\Domain\Exceptions\ProductAlreadyExists;
use App\Backoffice\Products\Domain\OptionalProduct;
use App\Backoffice\Products\Domain\Port\ProductRepository;
use App\Backoffice\Products\Domain\Product;
use App\Backoffice\Products\Domain\Service\ProductCreator;
use App\Backoffice\Products\Domain\Service\ProductSearcher;
use Tests\Backoffice\Products\Domain\ProductMother;
use Tests\TestCase;

/**
 * @group backoffice
 * @group products
 */
class ProductCreatorTest extends TestCase
{
    private ProductSearcher $searcher;
    private ProductRepository $repository;
    private ProductCreator $create;

    protected function setUp(): void
    {
        parent::setUp();
        $this->searcher = $this->createMock(ProductSearcher::class);
        $this->repository = $this->createMock(ProductRepository::class);
        $this->create = new ProductCreator($this->searcher, $this->repository);
    }

    public function testItShouldCreateProduct(): void
    {
        $expected = $product = ProductMother::random();

        $this->searcher->expects(self::once())
            ->method('searchById')
            ->with($product->id())
            ->willReturn(OptionalProduct::empty());

        $this->repository->expects(self::once())
            ->method('save');

        $result = $this->create->create(
            id: $product->id(),
            name: $product->name(),
            description: $product->description(),
            price: $product->price(),
            creatorId: $product->creatorId(),
        );

        $this->assertInstanceOf(Product::class, $result);
        $this->assertEquals($expected->id(), $result->id());
        $this->assertEquals($expected->name(), $result->name());
        $this->assertEquals($expected->description(), $result->description());
        $this->assertEquals($expected->price(), $result->price());
        $this->assertEquals($expected->creatorId(), $result->creatorId());
    }

    public function testItShouldThrowExceptionOnExistingId(): void
    {
        $expected = $product = ProductMother::random();

        $this->searcher->expects(self::once())
            ->method('searchById')
            ->with($product->id())
            ->willReturn(OptionalProduct::ofNullable($expected));

        $this->expectException(ProductAlreadyExists::class);

        $this->create->create(
            id: $product->id(),
            name: $product->name(),
            description: $product->description(),
            price: $product->price(),
            creatorId: $product->creatorId(),
        );
    }
}

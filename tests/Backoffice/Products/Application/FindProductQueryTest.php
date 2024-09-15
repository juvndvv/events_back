<?php

namespace Tests\Backoffice\Products\Application;

use App\Backoffice\Products\Application\Find\FindProductQuery;
use App\Backoffice\Products\Application\Find\FindProductQueryHandler;
use App\Backoffice\Products\Domain\Exceptions\ProductDoesntExist;
use App\Backoffice\Products\Domain\Service\ProductFinder;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Stub\ProductMother;
use Tests\TestCase;

class FindProductQueryTest extends TestCase
{
    private MockObject $productFinder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productFinder = $this->createMock(ProductFinder::class);
    }

    public function testItShouldRetrieveProduct(): void
    {
        $product = ProductMother::son();

        $this->productFinder->expects($this->once())
            ->method('__invoke')
            ->with($product->getId())
            ->willReturn($product);

        $command = FindProductQuery::create($product->getId());

        $handler = new FindProductQueryHandler($this->productFinder);

        $result = $handler($command)->toArray();

        $this->assertIsArray($result);
        $this->assertCount(9, $result);
        $this->assertEquals($product->getId(), $result['id']);
        $this->assertEquals($product->getName(), $result['name']);
        $this->assertEquals($product->getDescription(), $result['description']);
        $this->assertEquals($product->getPrice(), $result['price']);
        $this->assertEquals($product->getImage(), $result['image']);
        $this->assertEquals($product->getTotalSales(), $result['total_sales']);
        $this->assertEquals($product->getCreatedAt(), $result['created_at']);
        $this->assertEquals($product->getUpdatedAt(), $result['updated_at']);
        $this->assertEquals($product->getDeletedAt(), $result['deleted_at']);
    }

    public function testItShouldThrowProductDoesntExistException()
    {
        $this->productFinder->expects($this->once())
            ->method('__invoke')
            ->with('nonexistent')
            ->willReturn(null);

        $command = FindProductQuery::create('nonexistent');
        $handler = new FindProductQueryHandler($this->productFinder);

        $this->expectException(ProductDoesntExist::class);
        $handler($command);
    }
}

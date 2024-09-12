<?php

namespace Backoffice\Products\Domain\Service;

use App\Backoffice\Products\Domain\Port\ProductRepository;
use App\Backoffice\Products\Domain\Product;
use App\Backoffice\Products\Domain\Service\ProductFinder;
use App\Backoffice\Products\Domain\ValueObject\ProductDescription;
use App\Backoffice\Products\Domain\ValueObject\ProductImage;
use App\Backoffice\Products\Domain\ValueObject\ProductName;
use App\Backoffice\Products\Domain\ValueObject\ProductPrice;
use App\Shared\Domain\Identifier\UserId;
use PHPUnit\Framework\MockObject\MockObject;
use Stub\ProductMother;
use Tests\TestCase;

class ProductFinderTest extends TestCase
{
    private ProductFinder $productFinder;
    private MockObject $repository;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->repository = $this->createMock(ProductRepository::class);
        $this->productFinder = new ProductFinder($this->repository);
    }

    public function testShouldReturnNull(): void
    {
        $result =$this->productFinder->__invoke('nonexistentid');
        $this->assertNull($result);
    }

    public function testShouldReturnProduct(): void
    {
        // Arrange
        $name = ProductName::create('Product Name');
        $description = ProductDescription::create('Product Description');
        $image = ProductImage::create('https://example.com/product-image.jpg');
        $price = ProductPrice::create(100);
        $creatorId = UserId::generate();

        $product = Product::create($name, $description, $image, $price, $creatorId);

        $this->repository->expects($this->once())
            ->method('search')
            ->with($product->getId())
            ->willReturn($product);

        $result = $this->productFinder->__invoke($product->getId());

        $this->assertSame($product, $result);
    }
}
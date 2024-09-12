<?php

namespace Backoffice\Products\Domain\Service;

use App\Backoffice\Products\Domain\Service\ProductCreator;
use App\Backoffice\Products\Domain\Exceptions\ProductAlreadyExists;
use App\Backoffice\Products\Domain\Port\ProductRepository;
use App\Backoffice\Products\Domain\Service\ProductFinder;
use App\Backoffice\Products\Domain\Product;
use App\Backoffice\Products\Domain\ValueObject\ProductDescription;
use App\Backoffice\Products\Domain\ValueObject\ProductImage;
use App\Backoffice\Products\Domain\ValueObject\ProductName;
use App\Backoffice\Products\Domain\ValueObject\ProductPrice;
use App\Shared\Domain\Identifier\UserId;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

/**
 * @group backoffice
 * @group backoffice-products
 */
class ProductCreatorTest extends TestCase
{
    private ProductCreator $productCreator;
    private MockObject $finder;
    private MockObject $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->finder = $this->createMock(ProductFinder::class);
        $this->repository = $this->createMock(ProductRepository::class);
        $this->productCreator = new ProductCreator($this->finder, $this->repository);
    }

    public function testShouldCreateProduct(): void
    {
        // Arrange
        $name = ProductName::create('Product Name');
        $description = ProductDescription::create('Product Description');
        $image = ProductImage::create('https://example.com/product-image.jpg');
        $price = ProductPrice::create(100);
        $creatorId = UserId::generate();

        $product = Product::create($name, $description, $image, $price, $creatorId);

        $this->finder
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(null); // El producto no existe aún.

        $this->repository
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Product::class));

        // Act
        $createdProduct = $this->productCreator->__invoke($name, $description, $image, $price, $creatorId);

        // Assert
        $this->assertEquals($product->getName(), $createdProduct->getName());
        $this->assertEquals($product->getDescription(), $createdProduct->getDescription());
        $this->assertEquals($product->getImage(), $createdProduct->getImage());
        $this->assertEquals($product->getPrice(), $createdProduct->getPrice());
        $this->assertEquals($product->getCreatorId(), $createdProduct->getCreatorId());
    }

    public function testShouldThrowExceptionWhenProductAlreadyExists(): void
    {
        // Arrange
        $name = ProductName::create('Product Name');
        $description = ProductDescription::create('Product Description');
        $image = ProductImage::create('https://example.com/product-image.jpg');
        $price = ProductPrice::create(100);
        $creatorId = UserId::generate();

        $existingProduct = Product::create($name, $description, $image, $price, $creatorId);

        $this->finder
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn($existingProduct); // El producto ya existe.

        // Assert
        $this->expectException(ProductAlreadyExists::class);

        // Act
        $this->productCreator->__invoke($name, $description, $image, $price, $creatorId);
    }
}

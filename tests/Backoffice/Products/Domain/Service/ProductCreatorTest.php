<?php

namespace Backoffice\Products\Domain\Service;

use App\Backoffice\Products\Domain\Exceptions\ProductAlreadyExists;
use App\Backoffice\Products\Domain\Port\ProductRepository;
use App\Backoffice\Products\Domain\Product;
use App\Backoffice\Products\Domain\Service\ProductCreator;
use App\Backoffice\Products\Domain\Service\ProductFinder;
use App\Backoffice\Products\Domain\ValueObject\ProductDescription;
use App\Backoffice\Products\Domain\ValueObject\ProductImage;
use App\Backoffice\Products\Domain\ValueObject\ProductName;
use App\Backoffice\Products\Domain\ValueObject\ProductPrice;
use App\Shared\Domain\Identifier\UserId;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Stub\Backoffice\ProductMother;
use Tests\TestCase;

#[Group('domain')]
#[Group('backoffice')]
#[Group('backoffice-products')]
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

    public function testItShouldCreateProduct(): void
    {
        // Arrange
        $name = ProductName::create('Product Name');
        $description = ProductDescription::create('Product Description');
        $image = ProductImage::create('https://example.com/product-image.jpg');
        $price = ProductPrice::create(100);
        $creatorId = UserId::generate();

        $this->finder
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(null);

        $this->repository
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Product::class));

        // Act
        $createdProduct = $this->productCreator->__invoke($name, $description, $image, $price, $creatorId);

        // Assert
        $this->assertEquals($name->value(), $createdProduct->getName());
        $this->assertEquals($description->value(), $createdProduct->getDescription());
        $this->assertEquals($image->value(), $createdProduct->getImage());
        $this->assertEquals($price->value(), $createdProduct->getPrice());
        $this->assertEquals($creatorId->value(), $createdProduct->getCreatedBy());
    }

    public function testItShouldThrowExceptionWhenProductAlreadyExists(): void
    {
        // Arrange
        $name = ProductName::create('Product Name');
        $description = ProductDescription::create('Product Description');
        $image = ProductImage::create('https://example.com/product-image.jpg');
        $price = ProductPrice::create(100);
        $creatorId = UserId::generate();

        $existingProduct = ProductMother::son();

        $this->finder
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn($existingProduct);

        // Assert
        $this->expectException(ProductAlreadyExists::class);

        // Act
        $this->productCreator->__invoke($name, $description, $image, $price, $creatorId);
    }
}

<?php

namespace Tests\Backoffice\Products\Domain\Service;

use App\Backoffice\Products\Domain\Exceptions\ProductDoesntExist;
use App\Backoffice\Products\Domain\Port\ProductRepository;
use App\Backoffice\Products\Domain\Service\ProductFinder;
use App\Backoffice\Products\Domain\Service\ProductUpdater;
use App\Shared\Domain\Identifier\UserId;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Stub\ProductMother;
use Tests\TestCase;

class ProductUpdaterTest extends TestCase
{
    private ProductUpdater $productUpdater;
    private MockObject $repository;
    private MockObject $finder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->createMock(ProductRepository::class);
        $this->finder = $this->createMock(ProductFinder::class);
        $this->productUpdater = new ProductUpdater($this->finder, $this->repository);
    }

    public function testItShouldUpdate()
    {
        $product = ProductMother::son();

        $updater = UserId::generate()->value();
        $id = $product->getId();
        $name = 'newname';
        $description = 'newdescription';
        $image = 'newimage';
        $price = 90.12;

        $this->finder
            ->expects($this->once())
            ->method('__invoke')
            ->with($id)
            ->willReturn($product);

        $this->repository
            ->expects($this->once())
            ->method('update');

        $updated = $this->productUpdater->__invoke($updater, $id, $name, $description, $price, $image);

        $this->assertEquals($id, $updated->getId());
        $this->assertEquals($name, $updated->getName());
        $this->assertEquals($description, $updated->getDescription());
        $this->assertEquals($image, $updated->getImage());
        $this->assertEquals($price, $updated->getPrice());
    }

    public function testItShouldFailOnProductNotFound()
    {
        $product = ProductMother::son();

        $updater = UserId::generate()->value();
        $id = $product->getId();
        $name = 'newname';
        $description = 'newdescription';
        $image = 'newimage';
        $price = 90.12;

        $this->finder
            ->expects($this->once())
            ->method('__invoke')
            ->with($id)
            ->willReturn(null);


        $this->expectException(ProductDoesntExist::class);
        $this->productUpdater->__invoke($updater, $id, $name, $description, $price, $image);
    }
}

<?php

namespace Backoffice\Products\Domain\Service;

use App\Backoffice\Products\Domain\Service\ProductCreator;
use Stub\Backoffice\Product\ProductStub;
use Tests\TestCase;

/**
 * @group backoffice
 * @group backoffice-products
 */
class ProductCreatorTest extends TestCase
{
    private ProductCreator $productCreator;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testShouldCreateProduct(): void
    {
        $this->fail(json_encode((new ProductStub())->toPrimitives()));
    }
}

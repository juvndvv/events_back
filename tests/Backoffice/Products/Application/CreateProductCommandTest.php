<?php

namespace Tests\Backoffice\Products\Application;

use App\Backoffice\Products\Application\Create\CreateProductCommand;
use App\Backoffice\Products\Application\Create\CreateProductCommandHandler;
use App\Backoffice\Products\Domain\Service\ProductCreator;
use App\Shared\Domain\Identifier\UserId;
use PHPUnit\Framework\Attributes\Group;
use Tests\DbTestCase;

#[Group('application')]
#[Group('backoffice')]
#[Group('backoffice-products')]
class CreateProductCommandTest extends DbTestCase
{
    private ProductCreator $creator;
    protected function setUp(): void
    {
        parent::setUp();
        $this->creator = $this->app->make(ProductCreator::class);
    }

    public function testItShouldCreateProduct(): void
    {
        $name = 'Bolas chinas';
        $description = 'Bolas chinas con pinchos';
        $image = 'jkansj';
        $price = 0.79;
        $creatorId = UserId::generate()->value();

        $command = CreateProductCommand::create(
            name: $name,
            description: $description,
            image: $image,
            price: $price,
            creatorId: $creatorId
        );

        $handler = new CreateProductCommandHandler(
            $this->creator,
        );

        $id = $handler($command);

        $this->assertDatabaseHas('products', [
            'name' => $name,
            'description' => $description,
            'image' => $image,
            'price' => $price,
            'created_by' => $creatorId,
        ]);
    }
}

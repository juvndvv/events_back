<?php

namespace Tests\Backoffice\Products\Application;

use App\Backoffice\Products\Application\Create\CreateProductCommand;
use App\Backoffice\Products\Application\Create\CreateProductCommandHandler;
use App\Backoffice\Products\Domain\Service\ProductCreator;
use App\Shared\Domain\Identifier\UserId;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Stub\Backoffice\ProductMother;
use Tests\TestCase;

#[Group('application')]
#[Group('backoffice')]
#[Group('backoffice-products')]
class CreateProductCommandTest extends TestCase
{
    private MockObject $creator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->creator = $this->createMock(ProductCreator::class);
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

        $this->creator
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(ProductMother::son());

        $id = $handler($command);

        $this->assertNotEmpty($id);

        // TODO asegurar que se publica el evento
    }
}

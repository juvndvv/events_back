<?php

namespace Tests\Backoffice\Products\Application;

use App\Backoffice\Products\Application\Delete\DeleteProductCommand;
use App\Backoffice\Products\Application\Delete\DeleteProductCommandHandler;
use App\Backoffice\Products\Domain\Port\ProductRepository;
use App\Backoffice\Products\Domain\Service\ProductRemover;
use App\Shared\Domain\Identifier\UserId;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

#[Group('application')]
#[Group('backoffice')]
#[Group('backoffice-products')]
class DeleteProductCommandTest extends TestCase
{
    private MockObject $remover;

    protected function setUp(): void
    {
        parent::setUp();
        $this->remover = $this->createMock(ProductRemover::class);
    }

    public function testItShouldCallRemover(): void
    {
        $id = UserId::generate()->value();
        $activeUserId = UserId::generate()->value();

        $command = DeleteProductCommand::create($id, $activeUserId);

        $handler = new DeleteProductCommandHandler($this->remover);

        $this->remover
            ->expects($this->once())
            ->method('__invoke')
            ->with($id);

        $handler($command);
    }
}

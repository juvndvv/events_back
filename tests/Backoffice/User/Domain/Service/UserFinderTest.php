<?php

namespace Tests\Backoffice\User\Domain\Service;

use App\Backoffice\User\Domain\Port\UserRepository;
use App\Backoffice\User\Domain\Services\UserFinder;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Stub\UserMother;
use Tests\TestCase;

class UserFinderTest extends TestCase
{
    private UserFinder $finder;
    private MockObject $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->createMock(UserRepository::class);
        $this->finder = new UserFinder($this->repository);
    }

    public function testItShouldReturnNull()
    {
        $this->repository->expects($this->once())
            ->method('search')
            ->willReturn(null);

        $this->finder->findById('nonexistent');
    }

    public function testItShouldReturnUser()
    {
        $user = UserMother::son();

        $this->repository->expects($this->once())
            ->method('search')
            ->willReturn($user);

        $this->assertSame($user, $this->finder->findById($user->getId()));
    }
}

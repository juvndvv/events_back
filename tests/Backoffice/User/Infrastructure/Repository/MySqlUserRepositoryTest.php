<?php

namespace Tests\Backoffice\User\Infrastructure\Repository;

use App\Backoffice\User\Infrastructure\Repository\MySqlUserRepository;
use Illuminate\Support\Facades\DB;
use Tests\DbTestCase;
use Tests\Stub\UserMother;

class MySqlUserRepositoryTest extends DbTestCase
{
    private MySqlUserRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(MySqlUserRepository::class);
    }

    public function testItShouldSaveUser()
    {
        $user = UserMother::son();
        $this->repository->save($user);

        $this->assertDatabaseHas('users', $user->toPrimitives());
    }

    public function testItShouldUpdateUser()
    {
        $user = UserMother::son();
        $updatedUser = UserMother::son(id: $user->getId());

        DB::table('users')->insert($user->toPrimitives());

        $this->repository->update($updatedUser);

        $this->assertDatabaseHas('users', $updatedUser->toPrimitives());
    }

    public function testItShouldReturnNullOnSearch()
    {
        $result = $this->repository->search('');
        $this->assertNull($result);
    }

    public function testItShouldRetrieveUserOnSearch()
    {
        $user = UserMother::son();

        DB::table('users')->insert([
            $user->toPrimitives(),
            UserMother::son()->toPrimitives(),
            UserMother::son()->toPrimitives(),
            UserMother::son()->toPrimitives(),
        ]);

        $result = $this->repository->search($user->getId());

        $this->assertEquals($user->toPrimitives(), $result->toPrimitives());
    }

    public function testItShouldReturnNullOnSearchByEmail()
    {
        $result = $this->repository->searchByEmail('jd.forner@gmail.com');
        $this->assertNull($result);
    }

    public function testItShouldRetrieveUserOnSearchByEmail()
    {
        $user = UserMother::son();

        DB::table('users')->insert([
            $user->toPrimitives(),
            UserMother::son()->toPrimitives(),
            UserMother::son()->toPrimitives(),
            UserMother::son()->toPrimitives(),
        ]);

        $result = $this->repository->searchByEmail($user->getEmail());

        $this->assertEquals($user->toPrimitives(), $result->toPrimitives());
    }
}

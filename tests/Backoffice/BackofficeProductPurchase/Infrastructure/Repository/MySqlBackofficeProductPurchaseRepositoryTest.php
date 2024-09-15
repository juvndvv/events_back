<?php

namespace Tests\Backoffice\BackofficeProductPurchase\Infrastructure\Repository;

use App\Backoffice\BackofficeProductPurchases\Infrastructure\Repository\MySqlBackofficeProductPurchaseRepository;
use PHPUnit\Framework\Attributes\Group;
use Tests\DbTestCase;
use Tests\Stub\BackofficeProductPurchaseMother;

#[Group('infrastructure')]
class MySqlBackofficeProductPurchaseRepositoryTest extends DbTestCase
{
    private MySqlBackofficeProductPurchaseRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(MySqlBackofficeProductPurchaseRepository::class);
    }

    public function testItShouldSave(): void
    {
        $purchase = BackofficeProductPurchaseMother::son();

        $this->repository->save($purchase);

        $this->assertDatabaseHas('purchases', $purchase->toPrimitives());
    }
}

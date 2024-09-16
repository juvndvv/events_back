<?php

namespace Tests\Backoffice\BackofficeProductPurchase\Domain;

use App\Backoffice\BackofficeProductPurchases\Domain\Exception\OutOfStock;
use Tests\Stub\Backoffice\BackofficeProductPurchaseMother;
use Tests\TestCase;

class BackofficeProductPurchaseTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testItShouldReturnAvailable(): void
    {
        $purchase = BackofficeProductPurchaseMother::son(
            quantity: 3,
            expenses: 2,
        );

        $purchase2 = BackofficeProductPurchaseMother::son(
            quantity: 32123,
            expenses: 5497,
        );

        $this->assertEquals(1, $purchase->getAvailable());
        $this->assertEquals(32123 - 5497, $purchase2->getAvailable());
    }

    public function testItShouldUpdateExpense()
    {
        $purchase = BackofficeProductPurchaseMother::son(
            quantity: 3,
            expenses: 0,
        );

        $purchase->generateExpense(1);

        $this->assertEquals(1, $purchase->getExpenses());
    }

    public function testItShouldThrowOutOfStockWhenTryingToUseMoreThanAvailable()
    {
        $purchase = BackofficeProductPurchaseMother::son(
            quantity: 3,
            expenses: 3,
        );

        $this->expectException(OutOfStock::class);
        $purchase->generateExpense(1);
    }
}

<?php

namespace Tests\Backoffice\BackofficeProductPurchase\Domain\Service;

use App\Backoffice\BackofficeProductPurchases\Domain\Port\BackofficeProductPurchaseRepository;
use App\Backoffice\BackofficeProductPurchases\Domain\Service\BackofficeProductPurchaseCreator;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseBuyerEmail;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseBuyerName;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseQuantity;
use App\Backoffice\BackofficeProductPurchases\Domain\ValueObject\BackofficeProductPurchaseUnitPrice;
use App\Backoffice\Products\Domain\Exceptions\ProductDoesntExist;
use App\Backoffice\Products\Domain\Service\ProductFinder;
use App\Backoffice\User\Domain\Exception\UserDoesntExist;
use App\Backoffice\User\Domain\Services\UserFinder;
use App\Shared\Domain\Identifier\ProductId;
use App\Shared\Domain\Identifier\UserId;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Stub\BackofficeProductPurchaseMother;
use Tests\Stub\ProductMother;
use Tests\Stub\UserMother;
use Tests\TestCase;

class BackofficeProductPurchaseCreatorTest extends TestCase
{
    private MockObject $repository;
    private MockObject $productFinder;
    private MockObject $userFinder;
    private BackofficeProductPurchaseCreator $creator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->createMock(BackofficeProductPurchaseRepository::class);
        $this->productFinder = $this->createMock(ProductFinder::class);
        $this->userFinder = $this->createMock(UserFinder::class);
        $this->creator = new BackofficeProductPurchaseCreator($this->repository, $this->productFinder, $this->userFinder);
    }

    public function testShouldCreate(): void
    {
        $product = ProductMother::son();
        $user = UserMother::son();
        $purchase = BackofficeProductPurchaseMother::son(
            productId: $product->getId(),
            creatorId: $user->getId(),
            unitPrice: $product->getPrice(),
        );

        $productId = ProductId::create($purchase->getProductId());
        $userId = UserId::create($purchase->getCreatorId());

        $quantity = BackofficeProductPurchaseQuantity::create($purchase->getQuantity());
        $name = BackofficeProductPurchaseBuyerName::create($purchase->getBuyerName());
        $email = BackofficeProductPurchaseBuyerEmail::create($purchase->getBuyerEmail());

        $this->productFinder->expects($this->once())
            ->method('__invoke')
            ->with($product->getId())
            ->willReturn($product);

        $this->userFinder->expects($this->once())
            ->method('findById')
            ->with($user->getId())
            ->willReturn($user);

        $this->repository->expects($this->once())
            ->method('save');

        $result = $this->creator->__invoke(
            $productId,
            $userId,
            $quantity,
            $name,
            $email
        );

        $this->assertArrayIsIdenticalToArrayOnlyConsideringListOfKeys(
            $purchase->toPrimitives(),
            $result->toPrimitives(),
            ['product_id', 'buyer_name', 'buyer_email', 'unit_price', 'price', 'quantity']
        );
    }

    public function testItShouldThrowProductDoesntExist()
    {
        $user = UserMother::son();
        $purchase = BackofficeProductPurchaseMother::son(creatorId: $user->getId());

        $productId = ProductId::create($purchase->getProductId());
        $userId = UserId::create($purchase->getCreatorId());
        $quantity = BackofficeProductPurchaseQuantity::create($purchase->getQuantity());
        $name = BackofficeProductPurchaseBuyerName::create($purchase->getBuyerName());
        $email = BackofficeProductPurchaseBuyerEmail::create($purchase->getBuyerEmail());

        $this->userFinder->expects($this->never()   )
            ->method('findById')
            ->with($user->getId())
            ->willReturn($user);

        $this->expectException(ProductDoesntExist::class);
        $this->creator->__invoke(
            $productId,
            $userId,
            $quantity,
            $name,
            $email
        );
    }

    public function testItShouldThrowUserDoesntExist()
    {
        $product = ProductMother::son();
        $purchase = BackofficeProductPurchaseMother::son(productId: $product->getId());

        $productId = ProductId::create($purchase->getProductId());
        $userId = UserId::create($purchase->getCreatorId());
        $quantity = BackofficeProductPurchaseQuantity::create($purchase->getQuantity());
        $name = BackofficeProductPurchaseBuyerName::create($purchase->getBuyerName());
        $email = BackofficeProductPurchaseBuyerEmail::create($purchase->getBuyerEmail());

        $this->productFinder->expects($this->once())
            ->method('__invoke')
            ->with($product->getId())
            ->willReturn($product);

        $this->expectException(UserDoesntExist::class);

        $this->creator->__invoke(
            $productId,
            $userId,
            $quantity,
            $name,
            $email
        );
    }
}

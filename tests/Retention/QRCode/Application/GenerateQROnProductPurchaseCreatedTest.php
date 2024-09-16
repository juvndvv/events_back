<?php

namespace Tests\Retention\QRCode\Application;

use App\Retention\QRCode\Application\GenerateQR\GenerateQROnProductPurchaseCreated;
use App\Retention\QRCode\Domain\Service\QRCodeGenerator;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Stub\Backoffice\ProductPurchaseCreatedMother;
use Tests\TestCase;

#[Group('on-product-purchase-created')]
class GenerateQROnProductPurchaseCreatedTest extends TestCase
{
    private MockObject $qrCodeGenerator;
    private GenerateQROnProductPurchaseCreated $generateQROnProductPurchaseCreated;

    protected function setUp(): void
    {
        parent::setUp();
        $this->qrCodeGenerator = $this->createMock(QRCodeGenerator::class);
        $this->generateQROnProductPurchaseCreated = new GenerateQROnProductPurchaseCreated($this->qrCodeGenerator);
    }

    public function testItShouldGenerateQrCode(): void
    {
        $purchaseCreated = ProductPurchaseCreatedMother::son();

        $this->qrCodeGenerator
            ->expects($this->once())
            ->method('__invoke');

        $this->generateQROnProductPurchaseCreated->on($purchaseCreated);
    }
}

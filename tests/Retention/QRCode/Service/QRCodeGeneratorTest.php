<?php

namespace Tests\Retention\QRCode\Service;

use App\Backoffice\BackofficeProductPurchases\Domain\Service\BackofficeProductPurchaseFinder;
use App\Retention\QRCode\Domain\Port\QRCodeRepository;
use App\Retention\QRCode\Domain\Service\QRCodeGenerator;
use App\Retention\QRCode\Domain\ValueObject\QRCodePurchaseId;
use chillerlan\QRCode\QRCode as ChillerLanQRCode;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Stub\BackofficeProductPurchaseMother;
use Tests\TestCase;

class QRCodeGeneratorTest extends TestCase
{
    private MockObject $qrCodeRepository;
    private MockObject $purchaseFinder;
    private QRCodeGenerator $qrCodeGenerator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->qrCodeRepository = $this->createMock(QRCodeRepository::class);
        $this->purchaseFinder = $this->createMock(BackofficeProductPurchaseFinder::class);
        $this->qrCodeGenerator = new QRCodeGenerator($this->qrCodeRepository, $this->purchaseFinder);
    }

    public function testItShouldGenerateValidQRCode(): void
    {
        $purchase = BackofficeProductPurchaseMother::son();

        $id = QRCodePurchaseId::create($purchase->getId());

        $this->purchaseFinder
            ->expects($this->once())
            ->method('__invoke')
            ->with($purchase->getId())
            ->willReturn($purchase);

        $this->qrCodeRepository
            ->expects($this->once())
            ->method('save');

        $qr = $this->qrCodeGenerator->__invoke($id);

        $this->assertEquals($purchase->getId(), $qr->getPurchaseId());
    }
}

<?php

namespace App\Retention\QRCode\Application\GenerateQR;

use App\Backoffice\BackofficeProductPurchases\Domain\Event\ProductPurchaseCreated;
use App\Retention\QRCode\Domain\Service\QRCodeGenerator;
use App\Retention\QRCode\Domain\ValueObject\QRCodePurchaseId;
use App\Shared\Domain\Bus\Event\DomainEventSubscriber;
use App\Shared\Domain\Event\DomainEvent;

class GenerateQROnProductPurchaseCreated extends DomainEventSubscriber
{
    public function __construct(
        private readonly QRCodeGenerator $qrCodeGenerator
    )
    {
    }

    public function on(DomainEvent|ProductPurchaseCreated $event): void
    {
        $qr = $this->qrCodeGenerator->__invoke(QrCodePurchaseId::create($event->id));
    }

    public function subscribedTo(): string
    {
        return ProductPurchaseCreated::$eventName;
    }
}

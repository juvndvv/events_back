<?php

namespace App\Retention\QRCode\Domain;

use App\Retention\QRCode\Domain\Event\QRCodeCreated;
use App\Retention\QRCode\Domain\ValueObject\QRCodeContent;
use App\Retention\QRCode\Domain\ValueObject\QRCodePurchaseId;
use App\Shared\Domain\AggregateRoot;

class QRCode extends AggregateRoot
{
    private QRCodePurchaseId $purchaseId;
    private QRCodeContent $content;

    public function __construct(
        QRCodePurchaseId $purchaseId,
        QRCodeContent $content
    )
    {
        $this->purchaseId = $purchaseId;
        $this->content = $content;
    }

    public function getPurchaseId(): string
    {
        return $this->purchaseId->value();
    }

    public function getContent(): string
    {
        return $this->content->value();
    }

    public function toPrimitives(): array
    {
        return [
            'purchase_id' => $this->purchaseId->value(),
            'content' => $this->content->value(),
        ];
    }

    public static function create(QRCodePurchaseId $purchaseId, QRCodeContent $content): self
    {
        $qr = new self($purchaseId, $content);

        $qr->record(new QRCodeCreated());

        return $qr;
    }
}

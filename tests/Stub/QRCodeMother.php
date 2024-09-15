<?php

namespace Tests\Stub;

use App\Retention\QRCode\Domain\QRCode;
use App\Retention\QRCode\Domain\ValueObject\QRCodeContent;
use App\Retention\QRCode\Domain\ValueObject\QRCodePurchaseId;
use chillerlan\QRCode\QRCode as ChillerLanQRCode;

class QRCodeMother extends QRCode
{
    public static function son(
        ?string $purchaseId = null,
        ?string $content = null,
    ): QRCode {
        return new parent(
            $purchaseId ? QRCodePurchaseId::create($purchaseId) : QRCodePurchaseId::generate(),
            $content ? QRCodeContent::create($content) : self::generateQR(),
        );
    }

    private static function generateQR(): QRCodeContent
    {
        $data = 'testing';
        return QRCodeContent::create((new ChillerLanQRCode)->render($data));
    }
}

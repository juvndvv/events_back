<?php

namespace App\Retention\QRCode\Domain\Service;

use App\Backoffice\BackofficeProductPurchases\Domain\Exception\PurchaseDoesntExist;
use App\Backoffice\BackofficeProductPurchases\Domain\Service\BackofficeProductPurchaseFinder;
use App\Retention\QRCode\Domain\Port\QRCodeRepository;
use App\Retention\QRCode\Domain\QRCode;
use App\Retention\QRCode\Domain\ValueObject\QRCodeContent;
use App\Retention\QRCode\Domain\ValueObject\QRCodePurchaseId;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\QRGdImagePNG;
use chillerlan\QRCode\Output\QROutputInterface;
use chillerlan\QRCode\QRCode as ChillerLanQRCode;
use chillerlan\QRCode\QROptions;
use function Termwind\render;

class QRCodeGenerator
{
    public function __construct(
        private readonly QRCodeRepository                $repository,
        private readonly BackofficeProductPurchaseFinder $purchaseFinder,
    )
    {
    }

    public function __invoke(QRCodePurchaseId $purchaseId): QRCode
    {
        $this->ensurePurchaseExists($purchaseId);

        $options = new QROptions;

        $options->outputType       = QROutputInterface::FPDF;
        $options->scale            = 5;
        $options->fpdfMeasureUnit  = 'mm'; // pt, mm, cm, in
        $options->bgColor          = [222, 222, 222]; // [R, G, B]
        $options->drawLightModules = false;
        $options->moduleValues     = [
            QRMatrix::M_FINDER_DARK    => [0, 63, 255],    // dark (true)
            QRMatrix::M_FINDER_DOT     => [0, 63, 255],    // finder dot, dark (true)
            QRMatrix::M_FINDER         => [255, 255, 255], // light (false)
            QRMatrix::M_ALIGNMENT_DARK => [255, 0, 255],
            QRMatrix::M_ALIGNMENT      => [255, 255, 255],
            QRMatrix::M_DATA_DARK      => [0, 0, 0],
            QRMatrix::M_DATA           => [255, 255, 255],
        ];

        $content = (new ChillerLanQRCode($options))->render($purchaseId->value());

        $qr = QRCode::create($purchaseId, QRCodeContent::create($content));

        $this->repository->save($qr);

        return $qr;
    }

    private function ensurePurchaseExists(QRCodePurchaseId $purchaseId)
    {
        $purchase = $this->purchaseFinder->__invoke($purchaseId->value());

        if (null === $purchase) {
            throw new PurchaseDoesntExist($purchaseId->value());
        }
    }
}

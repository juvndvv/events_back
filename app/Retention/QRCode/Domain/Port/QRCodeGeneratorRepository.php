<?php

namespace App\Retention\QRCode\Domain\Port;

use App\Retention\QRCode\Domain\QRCode;
use chillerlan\QRCode\{QRCode as ChillerLanQRCode, QROptions};

interface QRCodeGeneratorRepository
{
    public function generate(string $purchaseId): void;
}

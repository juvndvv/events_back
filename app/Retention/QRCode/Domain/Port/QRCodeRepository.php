<?php

namespace App\Retention\QRCode\Domain\Port;

use App\Retention\QRCode\Domain\QRCode;
use chillerlan\QRCode\{QRCode as ChillerLanQRCode, QROptions};

interface QRCodeRepository
{
    public function save(QRCode $QRCode): void;
}

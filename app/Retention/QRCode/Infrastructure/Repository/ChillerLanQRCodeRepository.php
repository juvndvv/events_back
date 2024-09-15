<?php

namespace App\Retention\QRCode\Infrastructure\Repository;

use App\Retention\QRCode\Domain\Port\QRCodeGeneratorRepository;
use Illuminate\Support\Facades\DB;
use chillerlan\QRCode\{QRCode as ChillerLanQRCode, QROptions};


class ChillerLanQRCodeRepository implements QRCodeGeneratorRepository
{
    private const PATH = 'scan?qr=';

    public function generate(string $purchaseId): void
    {
        $data = self::PATH . $purchaseId;

        $qr = (new ChillerLanQRCode)->render($data);

        DB::table('purchases')
            ->where('id', $purchaseId)
            ->update([
                'qr' => $qr
            ]);
    }
}

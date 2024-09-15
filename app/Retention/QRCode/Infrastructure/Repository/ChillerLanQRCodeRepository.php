<?php

namespace App\Retention\QRCode\Infrastructure\Repository;

use App\Retention\QRCode\Domain\Port\QRCodeRepository;
use App\Retention\QRCode\Domain\QRCode;
use Illuminate\Support\Facades\DB;


class ChillerLanQRCodeRepository implements QRCodeRepository
{
    public function save(QRCode $QRCode): void
    {
        DB::table('qr_generations')->insert($QRCode->toPrimitives());
    }
}

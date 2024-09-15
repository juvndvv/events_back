<?php

namespace App\Backoffice\BackofficeProductPurchases\Infrastructure\Repository;

use App\Backoffice\BackofficeProductPurchases\Domain\BackofficeProductPurchase;
use App\Backoffice\BackofficeProductPurchases\Domain\Port\BackofficeProductPurchaseRepository;
use Illuminate\Support\Facades\DB;
use chillerlan\QRCode\{QRCode as ChillerLanQRCode, QROptions};
use stdClass;

class MySqlBackofficeProductPurchaseRepository implements BackofficeProductPurchaseRepository
{

    public function save(BackofficeProductPurchase $productPurchase): void
    {
        DB::table('purchases')
            ->insert($productPurchase->toPrimitives());
    }

    public function search(string $id): ?BackofficeProductPurchase
    {
        $db = DB::table('purchases')
            ->where('id', $id)
            ->first();

        if (null === $db) {
            return null;
        }

        $primitives = $this->retrievePrimitivesFromDbResult($db);

        return BackofficeProductPurchase::fromPrimitives($primitives);
    }

    public function searchByQRCode(array $file): ?BackofficeProductPurchase
    {
        $scanQR = (new ChillerLanQRCode())->readFromFile($file['tmp_name']);

        $db = DB::table('purchases')
            ->where('qr', $scanQR)
            ->first();

        if (null === $db) {
            return null;
        }

        $primitives = $this->retrievePrimitivesFromDbResult($db);

        return BackofficeProductPurchase::fromPrimitives($primitives);
    }

    private function retrievePrimitivesFromDbResult(stdClass $db): array
    {
        return [
            'id' => $db->id,
            'product_id' => $db->product_id,
            'creator_id' => $db->creator_id,
            'buyer_name' => $db->buyer_name,
            'buyer_email' => $db->buyer_email,
            'unit_price' => $db->unit_price,
            'quantity' => $db->quantity,
            'price' => $db->price,
            'purchased_at' => $db->purchased_at,
        ];
    }
}

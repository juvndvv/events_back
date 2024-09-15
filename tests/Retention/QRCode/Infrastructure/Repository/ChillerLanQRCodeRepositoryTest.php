<?php

namespace Tests\Retention\QRCode\Infrastructure\Repository;

use App\Retention\QRCode\Infrastructure\Repository\ChillerLanQRCodeRepository;
use Tests\DbTestCase;
use Tests\Stub\QRCodeMother;
use Tests\TestCase;

class ChillerLanQRCodeRepositoryTest extends DbTestCase
{
    private ChillerLanQRCodeRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new ChillerLanQRCodeRepository();
    }

    public function testItShouldSaveQrCode()
    {
        $qr = QRCodeMother::son();

        $this->repository->save($qr);

        $this->assertDatabaseHas('qr_generations', $qr->toPrimitives());
    }
}

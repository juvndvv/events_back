<?php

declare(strict_types=1);

namespace Tests\Shared\Infrastructure\Service\Filesystem;


use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * @group production
 */
class R2Test extends TestCase
{
    public function testItShouldConnectToR2()
    {
        try {
            $files = Storage::disk('r2')->allFiles();
            $this->assertIsArray($files, 'No se pudo obtener la lista de archivos desde el bucket de R2.');

        } catch (\Exception $e) {
            $this->fail('No se pudo conectar con Cloudflare R2: ' . $e->getMessage());
        }
    }
}

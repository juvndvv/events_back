<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Service\Storage\Implementations;

use App\Shared\Infrastructure\Service\Storage\Storage;
use Exception;

class R2StorageImplementation implements Storage
{
    private $disk;

    public function __construct()
    {
        $this->disk = \Illuminate\Support\Facades\Storage::disk('r2');
    }

    public function uploadFile(string $path, $content): string
    {
        $this->disk->put($path, $content);
        return $this->disk->url($path);
    }

    public function deleteFile(string $path): bool
    {
        try {
            return $this->disk->delete($path);

        } catch (Exception $e) {
            return false;
        }
    }
}

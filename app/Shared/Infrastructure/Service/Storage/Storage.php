<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Service\Storage;


interface Storage
{
    public function uploadFile(string $path, $content): string;
    public function deleteFile(string $path): bool;
}

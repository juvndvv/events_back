<?php

declare(strict_types=1);

namespace App\Backoffice\Products\Infrastructure;

use App\Backoffice\Products\Application\Create\CreateProductCommand;
use App\Backoffice\Products\Application\Create\CreateProductCommandHandler;
use App\Shared\Infrastructure\Provider\BaseServiceProvider;

class AppServiceProvider extends BaseServiceProvider
{
    protected function mapCommands(): void
    {
        $this->getCommandBus()->map([
            CreateProductCommand::class => CreateProductCommandHandler::class,
        ]);
    }
}

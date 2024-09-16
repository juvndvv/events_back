<?php

namespace App\Console\Commands;

use App\Shared\Domain\Bus\Event\KafkaEventBus;
use App\Shared\Domain\Event\PusherEventBus;
use Illuminate\Console\Command;
use Tests\Stub\Backoffice\ProductPurchaseCreatedMother;

class testing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:testing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $eventbus = new PusherEventBus();
        $eventbus->publish(ProductPurchaseCreatedMother::son());
    }
}

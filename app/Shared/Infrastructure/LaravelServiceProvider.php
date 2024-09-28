<?php

namespace App\Shared\Infrastructure;

use App\Shared\Infrastructure\Configuration\ServiceProvider\AbstractServiceProvider;
use Illuminate\Support\ServiceProvider;
use Psy\Util\Str;

class LaravelServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerDynamicProviders();
    }

    protected function registerDynamicProviders()
    {
        $abstractClass = AbstractServiceProvider::class;

        foreach (get_declared_classes() as $class) {
            if (is_subclass_of($class, $abstractClass)) {
                $this->app->register($class);
            }
        }
    }
}

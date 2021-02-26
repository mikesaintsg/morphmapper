<?php

namespace Mikesaintsg\MorphMapper;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    protected $configFilePath = __DIR__ . '/../config/morphmapper.php';

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Command::class,
            ]);
        }

        $this->publishes([$this->configFilePath => config_path('morphmapper.php')], 'morphmapper-config');

        Relation::morphMap((new MorphMapper())->morphMap);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/morphmapper.php', 'morphmapper');
    }
}

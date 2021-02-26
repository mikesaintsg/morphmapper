<?php

namespace Mikesaintsg\MorphMapper;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider as ServiceProvider;

class MorphMapperServiceProvider extends ServiceProvider
{
    protected $configFilePath = __DIR__ . '/../config/morphmapper.php';

    public function boot()
    {
        $this->publishes([$this->configFilePath => config_path('morphmapper.php')], 'morphmapper-config');

        Relation::morphMap(dd((new MorphMapper())->morphMap));
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/morphmapper.php', 'morphmapper');
    }
}

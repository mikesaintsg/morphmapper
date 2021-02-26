<?php

namespace Mikesaintsg\MorphMapper;

use Illuminate\Console\Command as LaravelCommand;
use Illuminate\Filesystem\Filesystem;

class Command extends LaravelCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'morphmapper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the MorphMapper config file.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        static::publishConfigFile();

        $this->info('MorphMapper config file added successfully.');
    }

    protected static function publishConfigFile(): void
    {
        copy(__DIR__ . '/../config/morphmapper.php', config_path('morphmapper.php'));
    }
}

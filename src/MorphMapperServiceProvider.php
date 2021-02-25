<?php

namespace Mikesaintsg\MorphMapper;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Support\Str;

class MorphMapperServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        Relation::morphMap($this->mapModels());
    }

    protected function mapModels()
    {
        return $this->getModels()->mapWithKeys(function ($file) {
            return [$this->modelKey($file) => $this->modelValue($file)];
        })->toArray();
    }

    protected function getModels()
    {
        return $this->modelsPathFiles()->map(function ($file) {
            return str_replace(".php", '', $file->getrelativepathname());
        });
    }

    private function modelsPathFiles()
    {
        return collect((new Filesystem())->allFiles(app_path('Models')));
    }

    protected function modelKey($file)
    {
        return str_replace("-", ".",stripslashes(Str::kebab($file)));
    }

    protected function modelValue($file)
    {
        return 'App\Models\\' . $file;
    }
}

<?php

namespace Mikesaintsg\MorphMapper;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MorphMapper
{
    public $morphMap = [];

    public function __construct()
    {
        $this->morphMap = $this->mergeMapModels();
    }

    protected function mergeMapModels()
    {
        return $this->discoverMapModels()->flip()->merge(collect(config('morphmapper.models.maps'))->flip())->unique()->flip()->toArray();
    }

    protected function discoverMapModels()
    {
        return $this->getModels()->mapWithKeys(function ($file) {return [$this->modelKey($file) => $this->modelValue($file)];});
    }

    protected function getModels()
    {
        return $this->modelsPathFiles()->map(function ($file) {return str_replace(".php", '', $file->getrelativepathname());});
    }

    private function modelsPathFiles()
    {
        return collect((new Filesystem())->allFiles(base_path(config('morphmapper.models.folder'))));
    }

    protected function modelKey($file)
    {
        return str_replace("-", config('morphmapper.delimiter'), stripslashes(Str::kebab($file)));
    }

    protected function modelValue($file)
    {
        return config('morphmapper.models.folder') . "\\" . $file;
    }
}

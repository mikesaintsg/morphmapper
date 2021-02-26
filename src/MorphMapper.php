<?php

namespace Mikesaintsg\MorphMapper;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MorphMapper
{
    public $morphMap = [];

    public function __construct()
    {
        $this->morphMap = $this->mergedDiscoveredModelsWithConfigModels();
    }

    protected function discoveredModelFilesFromFolder()
    {
        return collect((new Filesystem())->allFiles(base_path("App\Models")));
    }

    protected function discoveredModelFilesWithExtensionRemoved()
    {
        return $this->discoveredModelFilesFromFolder()->map(function ($file) {return str_replace(".php", '', $file->getrelativepathname());});
    }

    protected function discoveredModelsMapped()
    {
        return $this->discoveredModelFilesWithExtensionRemoved()->mapWithKeys(function ($file) {return [$this->generatedModelKey($file) => $this->generatedModelValue($file)];});
    }

    protected function generatedModelValue($file)
    {
        return "App\Models" . "\\" . $file;
    }

    protected function generatedModelKey($file)
    {
        return str_replace("-", config('morphmapper.delimiter'), $this->filePathBasedOnCaseSensitivity($file));
    }

    protected function filePathBasedOnCaseSensitivity($file)
    {
        return config('morphmapper.case-sensitive') ? stripslashes(Str::kebab($file)) : str_replace("\\", "-", strtolower($file));
    }

    protected function mergedDiscoveredModelsWithConfigModels()
    {
        return $this->discoveredModelsMapped()->flip()->merge(collect(config('morphmapper.overrides'))->flip())->unique()->flip()->toArray();
    }
}

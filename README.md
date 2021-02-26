<a id="top"></a>
# MorphMapper

This package will recursively discover all the Model files in the `App\Models` folder, then dynamically generate and register morphMap keys for those Model files.


## <a id="installation">Installation</a>
***

Install the composer package with:

```shell
composer require mikesaintsg/morphmapper
```

And you're done! Laravel uses Package Auto-Discovery, so it doesn't require you to manually add the ServiceProvider. 

>If your Laravel version does not use auto-discovery, then add the ServiceProvider below to the providers array in the `config/app.php` file.
>
>```php
>Mikesaintsg\MorphMapper\ServiceProvider::class,
>```

## <a id="usage">Usage</a>

***

Once installed, the Service Provider will dynamically generate and register morphMap keys for those Model files in your `App\Models` folder. A manual example of what is automatically done by this package is:

```
App\Models
    - User
    - Example
    - Folder\Foobar
```

```php 
[
    'user' => 'App\Models\User',
    'example' => 'App\Models\Example',
    'folder.foobar' => 'App\Models\Folder\Foobar'
];
```

## <a id="configuration">Configuration</a>
***
The configuration file can be published using one of the following commands:

```shell
php artisan vendor:publish --tag=morphmapper-config

php artisan morphmapper
```

Either of these commands will add the `config/morphmapper.php` file and provide the following default configurations:

```php
return [

    'delimiter' => '.',

    'case-sensitive' => false,

    'overrides' => [
        //
    ]
];
```

#### <a id="configuration-delimiters">Custom Delimiters (delimiter)</a>

Delimiter is defaulted to dot notation, but the delimiter can be replaced in the config file. Some examples of custom delimiters would be:

```shell
kebab-case-delimiter

snake_case_delimiter
```

#### <a id="configuration-case">Case Sensitivity (case-sensitive)</a>

Case Sensitivity is set to `false` since it is a preference and not a necessity. There are times when it is preferred with StudlyCase or camelCase files, but if you prefer folders to also be in studly or camel case, then case sensitivity can cause some confusion. It is best left up to you to decide what works best for you and your project.  

>#### Best Case Scenario
> You have a model with a file in studly case: `App\Models\Folder\ExampleModel`.
> 
> The morphMap key results for this Model based on case sensitivity would be:
> 
> ```
> case-sensitivity = "true";
> 
>   'folder.example.model' 
> 
> case-sensitivity = "false";
> 
>   'folder.examplemodel' 
> ```

>#### Worst Case Scenario
> You have a model with a file AND folder in studly case: `App\Models\FooBar\FooBarBaz`.
>
> The morphMap key results for this Model based on case sensitivity would be:
>
> ```
> case-sensitivity = "true";
> 
>   'foo.bar.foo.bar.baz' 
> 
> case-sensitivity = "false";
> 
>   'foobar.foobarbaz' 
> ```


#### <a id="configuration-overrides">Morph Map Override (overrides)</a>

There is always the chance that you may wish to override the keys that are automatically generated. Feel free to implement custom keys when you see fit for certain models. Make sure to include the fully qualified class name as the value in order to replace the key for the Model.

```php
    'overrides' => [
        'custom-key' => 'App\Models\Example'
    ];
```

<a href="#top">Back to Top</a>

## <a id="license">License</a>

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

#
#


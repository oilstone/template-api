<?php

namespace App\Factories;

use Exception;
use Illuminate\Support\Str;
use Stitch\Model;
use Stitch\Stitch as Service;

class Stitch
{
    /**
     * @var string[]
     */
    protected static array $models = [
        //
    ];

    /**
     * @return void
     */
    public static function boot(): void
    {
        foreach (static::$models as $model) {
            $makeMethod = 'make' . Str::ucfirst($model);

            Service::register($model, fn() => static::{$makeMethod}());
        }
    }

    /**
     * @param $name
     * @param $arguments
     * @return null|Model
     * @throws Exception
     */
    public static function __callStatic($name, $arguments): ?Model
    {
        return static::make($name);
    }

    /**
     * @param string $name
     * @return null|Model
     * @throws Exception
     */
    public static function make(string $name): ?Model
    {
        $model = Service::resolve($name);

        if (!$model) {
            throw new Exception("Unknown Stitch model [$name]");
        }

        return $model;
    }
}

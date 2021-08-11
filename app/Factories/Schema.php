<?php

namespace App\Factories;

use Api\Schema\Schema as BaseSchema;
use Closure;

class Schema
{
    /**
     * @return Closure
     */
    public static function default(): Closure
    {
        return function (BaseSchema $schema) {
            //
        };
    }
}

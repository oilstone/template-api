<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Str;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Throwable $e) {
            return response()->json([
                'errors' => [
                    [
                        'id' => Str::kebab(class_basename($e)),
                        'code' => $e->getCode(),
                        'status' => property_exists($e, 'status') ? $e->status : 500,
                        'title' => $e->getMessage(),
                    ]
                ],
            ], property_exists($e, 'status') ? $e->status : 500);
        });
    }
}

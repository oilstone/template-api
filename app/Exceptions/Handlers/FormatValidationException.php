<?php

/**
 * @noinspection PhpFullyQualifiedNameUsageInspection
 */

namespace App\Exceptions\Handlers;

use Illuminate\Support\Arr;
use Throwable;

class FormatValidationException extends FormatAnyException
{
    /**
     * A list of the exception types that this handler will respond to.
     *
     * @var array
     */
    protected array $respondsTo = [
        \Illuminate\Validation\ValidationException::class,
        \Api\Schema\Validation\ValidationException::class,
        \Respect\Validation\Exceptions\ValidationException::class,
    ];

    /**
     * @param Throwable $exception
     * @return int|null
     */
    protected function getStatus(Throwable $exception): ?int
    {
        return 422;
    }

    /**
     * @param Throwable $exception
     * @return string|null
     */
    protected function getId(Throwable $exception): ?string
    {
        return 'validation-error';
    }

    /**
     * @param Throwable $exception
     * @return string
     */
    protected function getTitle(Throwable $exception): string
    {
        return 'A validation error occurred';
    }

    /**
     * @param Throwable $exception
     * @return array|null
     */
    protected function getMeta(Throwable $exception): ?array
    {
        $meta = parent::getMeta($exception) ?? [];

        if (method_exists($exception, 'errors')) {
            $errorMessageTree = [];

            foreach ($exception->errors() as $key => $value) {
                Arr::set($errorMessageTree, $key, $value);
            }

            $meta = array_merge([
                'errorMessages' => $errorMessageTree,
            ], $meta);
        }

        return $meta;
    }
}

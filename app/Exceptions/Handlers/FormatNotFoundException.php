<?php

namespace App\Exceptions\Handlers;

use Api\Exceptions\NotFoundException;
use Api\Guards\OAuth2\League\Exceptions\AuthException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Throwable;

class FormatNotFoundException extends FormatAnyException
{
    /**
     * A list of the exception types that this handler will respond to.
     *
     * @var array
     */
    protected array $respondsTo = [
        NotFoundException::class,
        ModelNotFoundException::class,
    ];

    /**
     * @param Throwable $exception
     * @return int|null
     */
    public function getStatus(Throwable $exception): ?int
    {
        return 404;
    }

    /**
     * @param Throwable $exception
     * @return string
     */
    public function getId(Throwable $exception): string
    {
        return 'not-found';
    }

    /**
     * @param Throwable $exception
     * @return string
     */
    public function getTitle(Throwable $exception): string
    {
        if ($exception instanceof AuthException) {
            return $exception->getPayload()->getData()['error_description'] ?? $exception->getMessage();
        }

        if ($exception instanceof OAuthServerException) {
            return $exception->getPayload()['error_description'] ?? $exception->getMessage();
        }

        return 'Resource not found';
    }
}

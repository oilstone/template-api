<?php

namespace App\Exceptions\Handlers;

use Api\Guards\OAuth2\League\Exceptions\AuthException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Throwable;

class FormatAuthException extends FormatAnyException
{
    /**
     * A list of the exception types that this handler will respond to.
     *
     * @var array
     */
    protected array $respondsTo = [
        AuthException::class,
        OAuthServerException::class,
    ];

    /**
     * @param Throwable $exception
     * @return int|null
     */
    protected function getStatus(Throwable $exception): ?int
    {
        return 403;
    }

    /**
     * @param Throwable $exception
     * @return string
     */
    protected function getId(Throwable $exception): string
    {
        return 'access-denied';
    }

    /**
     * @param Throwable $exception
     * @return string
     */
    protected function getTitle(Throwable $exception): string
    {
        if ($exception instanceof AuthException) {
            return $exception->getPayload()->getData()['error_description'] ?? $exception->getMessage();
        }

        if ($exception instanceof OAuthServerException) {
            return $exception->getPayload()['error_description'] ?? $exception->getMessage();
        }

        return 'Access denied';
    }
}

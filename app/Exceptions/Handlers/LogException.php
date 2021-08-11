<?php

namespace App\Exceptions\Handlers;

use Api\Exceptions\Contracts\Handler;
use Api\Guards\OAuth2\League\Exceptions\AuthException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Reflector;
use Illuminate\Validation\ValidationException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class LogException implements Handler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected array $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        AuthException::class,
        OAuthServerException::class,
    ];

    /**
     * @param Throwable $exception
     * @return Throwable
     */
    public function process(Throwable $exception): Throwable
    {
        $reportable = is_null(Arr::first($this->dontReport, function ($type) use ($exception) {
            return $exception instanceof $type;
        }));

        if (!$reportable) {
            return $exception;
        }

        // Plug into Laravel's inbuilt reportable exception syntax to handle self-reporting exceptions
        if (Reflector::isCallable($reportCallable = [$exception, 'report'])) {
            if (app()->call($reportCallable) !== false) {
                return $exception;
            }
        }

        // If no other available option, log the exception using default logging process
        Log::error($exception->getMessage(), ['exception' => $exception]);

        return $exception;
    }

    /**
     * @param Throwable $exception
     * @return bool
     */
    public function respondsTo(Throwable $exception): bool
    {
        return false;
    }

    /**
     * @param Throwable $exception
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function prepareResponse(Throwable $exception, ResponseInterface $response): ResponseInterface
    {
        return $response;
    }
}

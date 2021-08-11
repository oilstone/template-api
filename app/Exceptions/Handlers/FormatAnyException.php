<?php

namespace App\Exceptions\Handlers;

use Api\Exceptions\Contracts\Handler;
use Api\Exceptions\Payload;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Neomerx\JsonApi\Encoder\Encoder;
use Neomerx\JsonApi\Schema\Error;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Throwable;

class FormatAnyException implements Handler
{
    /**
     * A list of the exception types that this handler will respond to.
     *
     * @var array
     */
    protected array $respondsTo = ['*'];

    /**
     * @param Throwable $exception
     * @return Throwable
     */
    public function process(Throwable $exception): Throwable
    {
        return $exception;
    }

    /**
     * @param Throwable $exception
     * @return bool
     */
    public function respondsTo(Throwable $exception): bool
    {
        return !is_null(Arr::first($this->respondsTo, function ($type) use ($exception) {
            if ($type === '*') {
                return true;
            }

            return $exception instanceof $type;
        }));
    }

    /**
     * @param Throwable $exception
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function prepareResponse(Throwable $exception, ResponseInterface $response): ResponseInterface
    {
        $httpStatus = $this->getStatus($exception);
        $meta = $this->getMeta($exception);

        $response->getBody()->write(Encoder::instance()->encodeError(new Error(
            $this->getId($exception),
            null,
            null,
            (string)$httpStatus,
            (string)$this->getCode($exception),
            $this->getTitle($exception),
            $this->getDetail($exception),
            null,
            (bool)$meta,
            $meta
        )));

        return $response->withStatus($httpStatus ?: 500);
    }

    /**
     * @param Throwable $exception
     * @return int|null
     */
    protected function getStatus(Throwable $exception): ?int
    {
        if (in_array($exception->getCode(), array_keys(Response::$statusTexts))) {
            return $exception->getCode();
        }

        if (method_exists($exception, 'getStatus')) {
            return $exception->getStatus();
        }

        return 500;
    }

    /**
     * @param Throwable $exception
     * @return array|null
     */
    protected function getMeta(Throwable $exception): ?array
    {
        $meta = [];
        $previous = $exception->getPrevious();

        if (method_exists($exception, 'meta')) {
            $meta = array_merge($meta, $exception->meta() ?? []);
        }

        if (method_exists($previous, 'meta')) {
            $meta = array_merge($meta, $previous->meta() ?? []);
        }

        if (method_exists($exception, 'getPayload')) {
            $payload = $exception->getPayload();

            if ($payload instanceof Payload) {
                $payload = $payload->getData();
            }

            $meta = array_merge($payload, $meta);
        }

        if (config('app.debug')) {
            $trace = FlattenException::createFromThrowable($exception)->toArray()[0] ?? [];

            $meta = array_merge($meta, $trace);
        }

        return $meta ?: null;
    }

    /**
     * @param Throwable $exception
     * @return string|null
     */
    protected function getId(Throwable $exception): ?string
    {
        if (method_exists($exception, 'getId')) {
            return $exception->getId();
        }

        return 'generic-error';
    }

    /**
     * @param Throwable $exception
     * @return int|null
     */
    protected function getCode(Throwable $exception): ?int
    {
        return $this->getStatus($exception);
    }

    /**
     * @param Throwable $exception
     * @return string
     */
    protected function getTitle(Throwable $exception): string
    {
        if (method_exists($exception, 'getTitle')) {
            return $exception->getTitle();
        }

        return 'An error occurred';
    }

    /**
     * @param Throwable $exception
     * @return string|null
     */
    protected function getDetail(Throwable $exception): ?string
    {
        $previous = $exception->getPrevious();

        if (method_exists($exception, 'detail')) {
            return $exception->detail();
        }

        if (method_exists($previous, 'detail')) {
            return $previous->detail();
        }

        return null;
    }
}

<?php

namespace App\Concerns;

use Api\Pipeline\Pipes\Pipe;
use App\Exceptions\UnauthorisedActionException;
use Psr\Http\Message\ServerRequestInterface;

trait BelongsToUser
{
    /**
     * @param Pipe $pipe
     * @param ServerRequestInterface|null $request
     * @return string|null
     * @throws UnauthorisedActionException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    protected function getAuthorisedUserId(Pipe $pipe, ?ServerRequestInterface $request = null): ?string
    {
        $userId = $this->getUserId($pipe, $request) ?? (property_exists($this, 'sentinel') ? $this->sentinel->getUserId() : null);

        if (method_exists($this, 'checkAuthorisation')) {
            $this->checkAuthorisation($userId);
        }

        return $userId;
    }

    /**
     * @param Pipe $pipe
     * @param ServerRequestInterface|null $request
     * @return string|null
     */
    protected function getUserId(Pipe $pipe, ?ServerRequestInterface $request = null): ?string
    {
        $userId = null;

        foreach ($pipe->ancestors() as $ancestor) {
            if ($ancestor->getEntity()->getName() === 'users') {
                $userId = $ancestor->getKey();
            }
        }

        if ($userId) {
            return $userId;
        }

        if (!$request) {
            return null;
        }

        $attributes = method_exists($this, 'getRequestBody') ? $this->getRequestBody($request) : $request->getParsedBody()['data']['attributes'];

        return $attributes['userId'] ?? $attributes['user']['id'] ?? null;
    }
}

<?php

namespace App\Concerns;

use Api\Queries\Query;
use Psr\Http\Message\ServerRequestInterface;

trait ParsesRequestData
{
    /**
     * @param ServerRequestInterface $request
     * @return array
     */
    protected function getRequestBody(ServerRequestInterface $request): array
    {
        return $request->getParsedBody()['data']['attributes'] ?? [];
    }

    /**
     * @param ServerRequestInterface $request
     * @return Query
     */
    protected function getRequestQuery(ServerRequestInterface $request): Query
    {
        return $request->getAttribute('query');
    }
}

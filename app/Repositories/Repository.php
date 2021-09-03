<?php

namespace App\Repositories;

use Api\Pipeline\Pipes\Pipe;
use Api\Repositories\Contracts\Resource;
use App\Concerns\AuthorisesRequests;
use App\Concerns\ParsesRequestData;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

/**
 * Class Repository.
 */
class Repository implements Resource
{
    use AuthorisesRequests, ParsesRequestData;

    /**
     * {@inheritdoc}
     * @throws MethodNotAllowedException
     */
    public function getCollection(Pipe $pipe, ServerRequestInterface $request): array
    {
        throw new MethodNotAllowedException([], 'This resource cannot be searched or indexed');
    }

    /**
     * {@inheritdoc}
     * @throws MethodNotAllowedException
     */
    public function getRecord(Pipe $pipe, ServerRequestInterface $request): ?array
    {
        return $this->getByKey($pipe);
    }

    /**
     * {@inheritdoc}
     * @throws MethodNotAllowedException
     */
    public function getByKey(Pipe $pipe): ?array
    {
        throw new MethodNotAllowedException([], 'This resource cannot be fetched by id');
    }

    /**
     * {@inheritdoc}
     * @throws MethodNotAllowedException
     */
    public function create(Pipe $pipe, ServerRequestInterface $request): array
    {
        throw new MethodNotAllowedException([], 'New instances of this resource cannot be created');
    }

    /**
     * {@inheritdoc}
     * @throws MethodNotAllowedException
     */
    public function update(Pipe $pipe, ServerRequestInterface $request): array
    {
        throw new MethodNotAllowedException([], 'This resource cannot be updated');
    }

    /**
     * {@inheritdoc}
     * @throws MethodNotAllowedException
     */
    public function delete(Pipe $pipe): array
    {
        throw new MethodNotAllowedException([], 'This resource cannot be deleted');
    }
}

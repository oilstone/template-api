<?php

namespace App\Repositories;

use Api\Pipeline\Pipes\Pipe;
use Api\Repositories\Contracts\Resource;
use Api\Repositories\Contracts\User as UserContract;
use Psr\Http\Message\ServerRequestInterface;

class User implements Resource, UserContract
{
    /**
     * @param Pipe $pipe
     * @return array|null
     */
    public function getByKey(Pipe $pipe): ?array
    {
        // TODO: Implement getByKey() method.
    }

    /**
     * @param Pipe $pipe
     * @param ServerRequestInterface $request
     * @return array
     */
    public function getCollection(Pipe $pipe, ServerRequestInterface $request): array
    {
        // TODO: Implement getCollection() method.
    }

    /**
     * @param Pipe $pipe
     * @param ServerRequestInterface $request
     * @return array|null
     */
    public function getRecord(Pipe $pipe, ServerRequestInterface $request): ?array
    {
        // TODO: Implement getRecord() method.
    }

    /**
     * @param Pipe $pipe
     * @param ServerRequestInterface $request
     * @return array
     */
    public function create(Pipe $pipe, ServerRequestInterface $request): array
    {
        // TODO: Implement create() method.
    }

    /**
     * @param Pipe $pipe
     * @param ServerRequestInterface $request
     * @return array
     */
    public function update(Pipe $pipe, ServerRequestInterface $request): array
    {
        // TODO: Implement update() method.
    }

    /**
     * @param Pipe $pipe
     * @return array
     */
    public function delete(Pipe $pipe): array
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param string $id
     * @return array|null
     */
    public function getById(string $id): ?array
    {
        // TODO: Implement getById() method.
    }

    /**
     * @param string $username
     * @param string $password
     * @return string|null
     */
    public function getIdByCredentials(string $username, string $password): ?string
    {
        // TODO: Implement getIdByCredentials() method.
    }
}

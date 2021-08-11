<?php

namespace App\Http\Controllers;

use Api\Api as Service;
use Illuminate\Routing\Controller as BaseController;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class Api extends BaseController
{
    /**
     * @var Service
     */
    protected Service $api;

    /**
     * Controller constructor.
     * @param Service $api
     */
    public function __construct(Service $api)
    {
        $this->api = $api;
    }

    /**
     * @return ResponseInterface
     * @throws Throwable
     */
    public function api(): ResponseInterface
    {
        return $this->respond($this->api->generateResponse());
    }

    /**
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    protected function respond(ResponseInterface $response): ResponseInterface
    {
        return $response->withHeader('Content-Type', 'application/vnd.api+json;charset=utf-8');
    }

    /**
     * @return ResponseInterface
     * @throws Throwable
     */
    public function oauth(): ResponseInterface
    {
        return $this->respond($this->api->generateAuthorisationResponse());
    }

    /**
     * @return ResponseInterface
     * @throws Throwable
     */
    public function oauthOwner(): ResponseInterface
    {
        return $this->respond($this->api->generateAuthorisedUserResponse());
    }
}

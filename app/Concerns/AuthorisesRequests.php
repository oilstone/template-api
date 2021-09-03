<?php

namespace App\Concerns;

use Api\Guards\Contracts\Sentinel;
use App\Exceptions\UnauthorisedActionException;
use App\Repositories\User;

trait AuthorisesRequests
{
    /**
     * @var array|null
     */
    protected ?array $requestUser;

    /**
     * @var string|null
     */
    protected ?string $authorisedUserId;

    /**
     * @var Sentinel|null
     */
    protected ?Sentinel $sentinel;

    /**
     * @param Sentinel|null $sentinel
     */
    public function setSentinel(?Sentinel $sentinel): void
    {
        $this->sentinel = $sentinel;
    }

    /**
     * @param string|null $requestUserId
     * @throws UnauthorisedActionException
     */
    protected function checkAuthorisation(?string $requestUserId): void
    {
        $this->fetchAuthorisedUserId();
        $this->fetchRequestUser($requestUserId);

        // No user affected by this request, allow
        if (!$this->requestUser) {
            return;
        }

        // Affected user is unconfirmed - check request is from a client token
        if (!$this->requestUser['emailConfirmed'] && !$this->authorisedUserId) {
            return;
        }

        // Check request comes from a matching user token
        if ($this->authorisedUserId === $this->requestUser['id']) {
            return;
        }

        throw new UnauthorisedActionException('The request user is not valid for the required authorisation of this action');
    }

    /**
     * @return void
     */
    protected function fetchAuthorisedUserId(): void
    {
        if (!$this->sentinel) {
            return;
        }

        if (!$this->authorisedUserId) {
            $this->authorisedUserId = $this->sentinel->getUserId();
        }
    }

    /**
     * @param string|null $requestUserId
     * @return void
     */
    protected function fetchRequestUser(?string $requestUserId): void
    {
        if (!$this->requestUser) {
            $this->requestUser = $requestUserId ? (new User())->getById($requestUserId) : null;
        }
    }

    /**
     * @return string|null
     */
    protected function authorisedUserId(): ?string
    {
        return $this->authorisedUserId;
    }

    /**
     * @return array|null
     */
    protected function requestUser(): ?array
    {
        return $this->requestUser;
    }
}

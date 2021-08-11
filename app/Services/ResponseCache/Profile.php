<?php

namespace App\Services\ResponseCache;

use Illuminate\Http\Request;
use Spatie\ResponseCache\CacheProfiles\CacheAllSuccessfulGetRequests;

class Profile extends CacheAllSuccessfulGetRequests
{
    /**
     * @var string[]
     */
    protected array $dontCache = [
        //
    ];

    /**
     * @param Request $request
     * @return bool
     */
    public function shouldCacheRequest(Request $request): bool
    {
        foreach ($request->segments() ?? [] as $segment) {
            if (in_array($segment, $this->dontCache)) {
                return false;
            }
        }

        return parent::shouldCacheRequest($request);
    }
}

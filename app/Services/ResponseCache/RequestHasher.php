<?php

namespace App\Services\ResponseCache;

use Illuminate\Http\Request;
use Spatie\ResponseCache\Hasher\DefaultHasher;
use Spatie\ResponseCache\Hasher\RequestHasher as RequestHasherContract;

class RequestHasher extends DefaultHasher implements RequestHasherContract
{
    /**
     * @param Request $request
     * @return string
     */
    public function getHashFor(Request $request): string
    {
        return 'responsecache-' . md5("{$request->getRequestUri()}/" . $this->cacheProfile->useCacheNameSuffix($request));
    }
}

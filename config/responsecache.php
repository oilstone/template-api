<?php

/**
 * @noinspection PhpFullyQualifiedNameUsageInspection
 */

return [
    /*
     *  The given class will determinate if a request should be cached. The
     *  default class will cache all successful GET-requests.
     *
     *  You can provide your own class given that it implements the
     *  CacheProfile interface.
     */
    'cache_profile' => \App\Services\ResponseCache\Profile::class,

    /*
     * This class is responsible for generating a hash for a request. This hash
     * is used to look up an cached response.
     */
    'hasher' => \App\Services\ResponseCache\RequestHasher::class,
];

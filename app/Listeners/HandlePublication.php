<?php

/** @noinspection PhpUndefinedFieldInspection */

namespace App\Listeners;

use Api\Api;
use Api\Guards\Contracts\Sentinel;
use Stitch\Events\Event;
use Stitch\Events\Listener;

class HandlePublication extends Listener
{
    /**
     * @param Event $event
     * @return void
     */
    public function creating(Event $event): void
    {
        $record = $event->getPayload()->record;

        $record->setAttribute('is_published', $record->is_published ?? 0);
    }

    /**
     * @param Event $event
     * @return void
     */
    public function fetching(Event $event): void
    {
        /** @var Sentinel $sentinel */
        $sentinel = app(Api::class)->getKernel()->resolve(Sentinel::class);

        if (!($sentinel->getUser()['is_admin'] ?? null)) {
            $event->getPayload()->query->where($event->getPayload()->path->to('is_published'), '1');
        }
    }
}

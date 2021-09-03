<?php

/** @noinspection PhpUndefinedFieldInspection */

namespace App\Listeners;

use Api\Api;
use Api\Guards\Contracts\Sentinel;
use Carbon\Carbon;
use Stitch\Events\Event;
use Stitch\Events\Listener;

class HandlePublicationDate extends Listener
{
    /**
     * @param Event $event
     * @return void
     */
    public function creating(Event $event): void
    {
        $record = $event->getPayload()->record;

        if (!$record->publish_at && $record->is_published) {
            $record->setAttribute('publish_at', Carbon::now()->toDateTimeString());
        }
    }

    /**
     * @param Event $event
     * @return void
     */
    public function updating(Event $event): void
    {
        $record = $event->getPayload()->record;

        if (!$record->publish_at && $record->is_published) {
            $record->setAttribute('publish_at', Carbon::now()->toDateTimeString());
        }
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
            $event->getPayload()->query->where(function ($query) use ($event) {
                $query
                    ->where($event->getPayload()->path->to('publish_at'), '<=', Carbon::now()->toDateTimeString())
                    ->orWhere($event->getPayload()->path->to('publish_at'), '=', null);
            });
        }
    }
}

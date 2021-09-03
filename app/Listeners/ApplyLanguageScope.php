<?php

/** @noinspection PhpUndefinedFieldInspection */

namespace App\Listeners;

use Stitch\Events\Event;
use Stitch\Events\Listener;

class ApplyLanguageScope extends Listener
{
    /**
     * @param Event $event
     * @return void
     */
    public function fetching(Event $event): void
    {
        $event->getPayload()->query->where($event->getPayload()->path->to('language'), app()->getLocale());
    }

    /**
     * @param Event $event
     * @return void
     */
    public function creating(Event $event): void
    {
        $event->getPayload()->record->setAttribute('language', app()->getLocale());
    }
}

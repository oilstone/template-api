<?php

/** @noinspection PhpUndefinedFieldInspection */

namespace App\Listeners;

use Illuminate\Support\Str;
use Stitch\Events\Event;
use Stitch\Events\Listener;

class GenerateSlug extends Listener
{
    /**
     * @param Event $event
     * @return void
     */
    public function creating(Event $event): void
    {
        $record = $event->getPayload()->record;

        $record->setAttribute('slug', Str::slug($record->title));
    }

    /**
     * @param Event $event
     * @return void
     */
    public function updating(Event $event): void
    {
        $record = $event->getPayload()->record;

        if (!$record->slug) {
            $record->setAttribute('slug', Str::slug($record->title));
        }
    }
}

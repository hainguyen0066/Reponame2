<?php

namespace App\Listeners;

use App\Event\PostCreatingEvent;
use Illuminate\Support\Carbon;

class PostCreatingListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PostCreatingEvent $event
     *
     * @return void
     */
    public function handle(PostCreatingEvent $event)
    {
        if (empty($event->post->publish_date)) {
            $event->post->publish_date = Carbon::now();
        }
    }
}

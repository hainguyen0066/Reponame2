<?php

namespace App\Event;

use App\Models\Post;
use Illuminate\Queue\SerializesModels;

/**
 * Class PostSavingEvent
 *
 * @package \App\Event
 */
class PostCreatingEvent
{
    use SerializesModels;

    /**
     * @var \App\Models\Post
     */
    public $post;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }
}

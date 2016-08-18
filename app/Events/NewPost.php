<?php
/**
 * Created by PhpStorm.
 * User: PokLin
 * Date: 18/7/2016
 * Time: 12:09 PM
 */


namespace App\Events;
use App\Models\Post;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewPost extends Event
{
    use SerializesModels;
    public $post;
    /**
     * NewPost constructor.
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }
    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
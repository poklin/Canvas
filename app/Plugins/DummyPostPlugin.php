<?php
/**
 * Created by PhpStorm.
 * User: PokLin
 * Date: 18/7/2016
 * Time: 12:21 PM
 */

namespace App\Plugins;
use App\Models\Post;
use App\Plugins\Interfaces\PostInterface;

class DummyPostPlugin implements PostInterface
{
    public function getName()
    {
        return 'Dummy Post Plugin';
    }
    public function getVersion()
    {
        return '1.0';
    }
    public function process(Post $post)
    {
        \Log::info("New Post: " . $post->title);
    }
}
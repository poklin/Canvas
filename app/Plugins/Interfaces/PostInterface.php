<?php
/**
 * Created by PhpStorm.
 * User: PokLin
 * Date: 18/7/2016
 * Time: 12:22 PM
 */

namespace App\Plugins\Interfaces;
use App\Models\Post;

interface PostInterface
{
    public function getName();
    public function getVersion();
    public function process(Post $post);
}
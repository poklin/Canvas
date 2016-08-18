<?php
/**
 * Created by PhpStorm.
 * User: PokLin
 * Date: 21/7/2016
 * Time: 11:09 AM
 */

namespace App\Console\Commands;
use Illuminate\Console\Command;
use TeamTNT\TNTSearch\TNTSearch;

class IndexPosts extends Command
{
    protected $tnt;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'canvas:indexer';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index the posts and tags table';
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->tnt = new TNTSearch;
        $this->tnt->loadConfig(config('services.tntsearch'));
        $this->createPostsIndex();
        $this->createTagsIndex();
    }
    public function createPostsIndex()
    {
        $this->info("Indexing posts table and saving it to posts.index");
        $indexer = $this->tnt->createIndex('posts.index');
        $indexer->query('SELECT id, title, subtitle, content_raw, meta_description FROM posts;');
        $indexer->run();
    }
    public function createTagsIndex()
    {
        $this->info("Indexing tags table and saving it to tags.index");
        $indexer = $this->tnt->createIndex('tags.index');
        $indexer->query('SELECT id, tag, title, subtitle, meta_description FROM tags;');
        $indexer->run();
    }
}
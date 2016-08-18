<?php
namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Post;
use Illuminate\Contracts\Bus\SelfHandling;

class PostFormFields extends Job implements SelfHandling
{
    /**
     * The slug (if any) of the Post row
     *
     * @var String slug
     */
    protected $slug;
    /**
     * List of fields and default value for each field
     *
     * @var array
     */
    protected $fieldList = [
        'user_id' => '',
        'title' => '',
        'slug' => '',
        'subtitle' => '',
        'page_image' => '',
        'content' => '',
        'meta_description' => '',
        'is_draft' => "0",
        'publish_date' => '',
        'publish_time' => '',
        'published_at' => '',
        'updated_at' => '',
        'layout' => 'frontend.blog.post',
        'tags' => [],
    ];

    /**
     * Create a new command instance.
     *
     * @param integer $id
     */
    public function __construct($slug = null)
    {
        $this->slug = $slug;
    }

    /**
     * Execute the command.
     *
     * @return array of fieldnames => values
     */
    public function handle()
    {
        if($this->slug)
        {
            $post = Post::with('tags')->whereSlug($this->slug)->firstOrFail();
        }
        
        $fields = $this->fieldList;
        if ($this->slug) {
            $fields = $this->fieldsFromModel($post->id, $fields);
        } else {
            $when = Carbon::now()->addHour();
            $fields['publish_date'] = $when->format('M-j-Y');
            $fields['publish_time'] = $when->format('g:i A');
        }
        foreach ($fields as $fieldName => $fieldValue) {
            $fields[$fieldName] = old($fieldName, $fieldValue);
        }
        return array_merge(
            $fields,
            ['allTags' => Tag::lists('tag')->all()]
        );
    }

    /**
     * Return the field values from the model
     *
     * @param integer $id
     * @param array $fields
     * @return array
     */
    protected function fieldsFromModel($id, array $fields)
    {
        $post = Post::findOrFail($id);
        $fieldNames = array_keys(array_except($fields, ['tags']));
        $fields = ['id' => $id];
        foreach ($fieldNames as $field) {
            $fields[$field] = $post->{$field};
        }
        $fields['tags'] = $post->tags()->lists('tag')->all();
        return $fields;
    }
}
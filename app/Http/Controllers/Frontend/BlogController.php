<?php
namespace App\Http\Controllers\Frontend;

use App\Models\Tag;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Http\Requests;
use App\Jobs\BlogIndexData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // user is followed by
        // dd($user->followers()->get());
        // user is following

        $tag = $request->get('tag');
        $search = $request->get('search');
        $data = $this->dispatch(new BlogIndexData($tag,$search,null));
        $layout = $tag ? Tag::layout($tag)->first() : 'frontend.blog.index1';
        return view($layout, $data)->with(compact('user'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPosts($id, Request $request)
    {
        $user = DB::table('users')->where('display_name',$id)->first();
        $tag = $request->get('tag');
        $search = $request->get('search');
        $data = $this->dispatch(new BlogIndexData($tag,$search,$user->id));
        $layout = $tag ? Tag::layout($tag)->first() : 'frontend.blog.index1';
        return view($layout, $data)->with(compact('user'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPost($id, $slug, Request $request)
    {
        //$user = User::findOrFail(1);
        $post = Post::with('tags')->whereSlug($slug)->firstOrFail();
        $tag = $request->get('tag');

        $title = $post->title;
        if ($tag) {
            $tag = Tag::whereTag($tag)->firstOrFail();
        }

        return view($post->layout, compact('post', 'tag', 'slug', 'title', 'user'));
    }
}

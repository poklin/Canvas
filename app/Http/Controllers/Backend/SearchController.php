<?php

namespace App\Http\Controllers\Backend;

use App\Models\Tag;
use App\Models\Post;
use App\Http\Requests;
use App\Services\Search;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * Display search result.
     *
     * @return \Illuminate\View\View
     */
    public function index(Search $search)
    {
        $user = Auth::user();
        $params = \Request::get('search');

        if($user->hasRole('Admin'))
        {
            $posts = Post::where('title', 'LIKE', '%'.$params.'%')->get();
            $tags = Tag::where('title', 'LIKE', '%'.$params.'%')->get();
        }
        else
        {
            $posts = Post::where('title', 'LIKE', '%'.$params.'%')
                ->where('user_id', '=', $user->id)->get();
            $tags = Tag::where('title', 'LIKE', '%'.$params.'%')->get();
        }

        //$posts = $search->posts();
        //$tags  = $search->tags();

        return view('backend.search.index', compact('params', 'posts', 'tags'));
    }
}

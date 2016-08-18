<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests;
use Illuminate\Routing\Controller as BaseController;
use Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class FollowController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function follow()
    {
        // Getting all post data
        if(Request::ajax()) {
            $data = Input::all();
            $id = array_get($data,'id');

            $user = Auth::user();
            $user->follow($id);

            //print($id);die;
        }
    }

    public function unfollow()
    {
        // Getting all post data
        if(Request::ajax()) {
            $data = Input::all();
            $id = array_get($data,'id');

            $user = Auth::user();
            $user->unfollow($id);
        }
    }
}

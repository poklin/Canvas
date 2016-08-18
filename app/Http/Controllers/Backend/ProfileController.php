<?php

namespace App\Http\Controllers\Backend;

use Auth;
use Session;
use App\Models\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user profile page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $userData = Auth::user()->toArray();
        $blogData = config('blog');
        $data = array_merge($userData, $blogData);

        return view('backend.profile.index', compact('data'));
    }

    /**
     * Display the user profile edit page
     *
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        if (Auth::user()->id == $id)
        {
            $userData = User::where('id', $id)->firstOrFail()->toArray();
            $blogData = config('blog');
            $data = array_merge($userData, $blogData);

            return view('backend.profile.edit', compact('data'));
        }
        return response("Insufficient Permission", 401);

    }

    public function editPrivacy()
    {
        return view('backend.profile.privacy', [
            "data" => array_merge(Auth::user()->toArray(), config('blog'))
        ]);
    }

    /**
     * Update the user profile information.
     *
     * @param ProfileUpdateRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->fill($request->toArray())->save();
        $user->save();

        Session::set('_profile', trans('messages.update_success', ['entity' => 'Profile']));
        return redirect()->route('admin.profile.edit', $id);
    }
}

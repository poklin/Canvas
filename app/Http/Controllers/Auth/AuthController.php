<?php
namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use Session;
use Validator;
use JsValidator;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectAfterLogout = '';
    protected $redirectTo = 'admin/post';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:40',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'display_name' => 'required|max:40|unique:users',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'display_name' => $data['display_name'],
        ]); 
    }

    public function authenticated(\Illuminate\Http\Request $request, User $user)
    {
        Session::set('_login', trans('messages.login', ['first_name' => $user->first_name, 'last_name' => $user->last_name]));
        return redirect()->intended($this->redirectPath());
    }

    public function redirectToFacebook()
    {
        return Socialite::with('facebook')->redirect();
    }

    public function getFacebookCallback()
    {
        $data = Socialite::with('facebook')->user();
        $user = User::where('email',$data->email)->first();

        if(!is_null($user))
        {
            Auth::login($user);
            $user->last_name = $data->user['name'];
            $user->facebook_id = $data->id;
            $user->save();
        } else {
            $user = User::where('facebook_id',$data->id)->first();
            if(is_null($user)) {
                //Create a new user
                $user = new User();
                $user->last_name = $data->user['name'];
                $user->email = $data->email;
                $user->facebook_id = $data->id;
                $user->save();
            }

            Auth::login($user);
        }
        return redirect('/')->with('success','Successfully Logged In!');
    }

}

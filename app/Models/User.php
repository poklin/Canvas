<?php
namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'display_name', 'url', 'facebook_id', 'twitter', 'facebook', 'github', 'address', 'city', 'country', 'bio', 'job', 'phone', 'gender', 'relationship', 'birthday', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    /**
     * Get the posts relationship.
     *
     * @return hasMany
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }

    /**
     * Get the roles relationship.
     *
     * @return BelongsToMany
     */
    public function role()
    {
        return $this->belongsToMany('App\Models\Role', 'user_role', 'user_id', 'role_id');
    }

    /**
     * Check the role of the user with the argument.
     *
     * @param string $role
     * @return boolean
     */
    public function hasRole($role)
    {
        if($this->role()->where('name',$role)->first()) {
            return true;
        }
        return false;
    }

    /**
     * Assign the role of the user with the argument.
     *
     * @param string $role
     * @return boolean
     */
    public function assignRole($role)
    {
        $assignedRole = Role::find($role);
        $this->role()->save($assignedRole);
    }

    /**
     * Check is the post belongs to the user
     *
     * @param int $post_id
     *
     * @return Boolean
     */
    public function checkPostsOwner($post_id)
    {
        $post = Post::findOrFail($post_id);
        $user = Auth::user();

        if($post->user_id === $user->id)
        {
            return true;
        }
        return false;
    }

    /**
     * One User Has Many Followers
     */
    public function followers()
    {
        return $this->belongsToMany(
            self::class,
            'follows',
            'followee_id',
            'follower_id'
        );
    }

    /**
     * One User Follows Many Users
     */
    public function followees()
    {
        return $this->belongsToMany(
            self::class,
            'follows',
            'follower_id',
            'followee_id'
        );
    }

    public function follow($followUser)
    {
        $User = User::find($followUser);
        $this->followees()->save($User);

    }

    public function unfollow($followUser)
    {
        $User = User::find($followUser);
        $this->followees()->detach($User);
    }
}

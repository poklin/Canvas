<?php
/*
|--------------------------------------------------------------------------
| Blog Routes
|--------------------------------------------------------------------------
*/
Route::get('/', 'Frontend\BlogController@index');
Route::get('blog', 'Frontend\BlogController@index');
Route::get('blog/{slug}', 'Frontend\BlogController@showPost');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::get('admin', function () {
    return redirect('/admin/post');
});

$router->group([
    'namespace'  => 'Backend',
    'middleware' => 'role',
    'role' =>['Author','Admin'],
], function () {
    Route::resource('admin/post', 'PostController', ['except' => 'show']);
    Route::resource('admin/tag', 'TagController', ['except' => 'show']);
    Route::get('admin/upload', 'UploadController@index')->name('admin/upload');
    Route::post('admin/upload/file', 'UploadController@uploadFile');
    Route::delete('admin/upload/file', 'UploadController@deleteFile');
    Route::post('admin/upload/folder', 'UploadController@createFolder');
    Route::delete('admin/upload/folder', 'UploadController@deleteFolder');
    Route::get('admin/profile/privacy', 'ProfileController@editPrivacy')->name('admin.profile.privacy');
    Route::resource('admin/profile', 'ProfileController');
    Route::resource('admin/search', 'SearchController');
});

/*
|--------------------------------------------------------------------------
| Logging In/Out Routes
|--------------------------------------------------------------------------
*/
$router->group([
    'namespace' => 'Auth',
    'prefix'    => 'auth',
], function () {
    Route::get('login', 'AuthController@getLogin');
    Route::post('login', 'AuthController@postLogin');
    Route::get('logout', 'AuthController@getLogout');
    Route::post('password', 'PasswordController@updatePassword');
    Route::get('register', 'AuthController@showRegistrationForm');
    Route::post('register', 'AuthController@register');
});

Route::auth();

Route::get('/home', 'HomeController@index');

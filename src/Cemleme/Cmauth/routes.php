<?php

Route::group(array('middleware' => 'auth'), function()
{

	Route::get('cmauth/user/settings', 'Cemleme\Cmauth\controllers\UsersController@changePasswordView');

	Route::put('cmauth/users/{id}/welcomemail', 'Cemleme\Cmauth\controllers\UsersController@sendWelcomeMailToUser');
	Route::put('cmauth/users/{id}/yenisifremail', 'Cemleme\Cmauth\controllers\UsersController@sendNewPasswordMailToUser');

	Route::post('cmauth/users/{id}/groups/connect', 'Cemleme\Cmauth\controllers\UsersController@connectUserGroup');
	Route::delete('cmauth/users/{uid}/groups/{gid}', 'Cemleme\Cmauth\controllers\UsersController@deleteUserGroup');
	Route::post('cmauth/groups/{id}/permissions/connect', 'Cemleme\Cmauth\controllers\UsersController@connectGroupPermission');
	Route::delete('cmauth/groups/{gid}/permissions/{pid}', 'Cemleme\Cmauth\controllers\UsersController@deleteGroupPermission');
	Route::controller('cmauth/usersapp', 'Cemleme\Cmauth\controllers\UsersController');

	Route::resource('cmauth/users', 'Cemleme\Cmauth\controllers\UsersRC');
	Route::resource('cmauth/groups', 'Cemleme\Cmauth\controllers\GroupsRC');
	Route::resource('cmauth/permissions', 'Cemleme\Cmauth\controllers\PermissionsRC');

});

Route::controllers([
	'cmauth' => 'Cemleme\Cmauth\controllers\AuthController',
	'auth' => 'Cemleme\Cmauth\controllers\AuthController',
	'password' => 'Cemleme\Cmauth\controllers\PasswordController',
]);
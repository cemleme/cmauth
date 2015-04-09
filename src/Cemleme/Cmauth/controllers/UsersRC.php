<?php

namespace Cemleme\Cmauth\controllers;

use View;
use Redirect;
use Input;
use Validator;
use Hash;

use User;

class UsersRC extends BaseController {
	
	public function __construct() {
		$this->beforeFilter('acl.permitted:AppsUsersEdit'); 
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return $this->returnLayout('cmauth::users.list', ['users' => User::all()]);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return $this->returnLayout('cmauth::users.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		
		$validator = Validator::make(Input::all(), User::$rules_new_user);
	 
		if ($validator->passes()) {
			$user = new User;
			$user->name = Input::get('name');
			$user->email = Input::get('email');
			$password =	substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 6 );
			$user->password = Hash::make($password);
			//$user->password = Hash::make(Input::get('password'));
			$user->save();

			return Redirect::to('/cmauth/users')->with('message', 'User Created!');
		} 
		else {
			return Redirect::to('/cmauth/users/create')->withErrors($validator)->withInput();
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//return $this->returnLayout('cmauth::listusers', ['users' => User::all()]);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return $this->returnLayout('cmauth::users.edit', ['user' => User::find($id)]);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$user = User::findOrFail($id);
		$user->fill(Input::all());
		$user->save();
		
		return Redirect::to('/cmauth/users');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// delete
		$user = User::find($id);
		$user->groups()->detach();
		$user->delete();

		return Redirect::to('/cmauth/users');
	}

}

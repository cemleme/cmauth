<?php namespace Cemleme\Cmauth\controllers;

use View;
use Redirect;
use Input;
use Auth;
use Session;
use Validator;
use Hash;
use DateTime;
use User;

use Cemleme\Cmauth\managers\UserPermissionRefresher;

class AuthController extends BaseController {

	//protected $connection="mysqlauthdb";
	protected $permissionRefresher;

	public function __construct(UserPermissionRefresher $permissionRefresher) { 
		$this->permissionRefresher = $permissionRefresher;

		$this->middleware('auth', ['except' => ['getLogin', 'postLogin']]); 
	}
	
	public function getIndex() {
		return $this->returnLayout('cmauth::dashboard');
	}
	
	public function getLogin() {
		return view('auth.login');
		//return View::make('cmauth::login');
	}
	
	public function postLogin() {
	
		$remember = (Input::has('remember')) ? true : false;
	
		if (Auth::attempt(array('email'=>Input::get('email'), 'password'=>Input::get('password')),$remember)) {
			
			//date_default_timezone_set('Europe/Istanbul');
			
			$user = Auth::user();
			$user->last_login = new DateTime();
    		$user->save();

    		$this->permissionRefresher->refreshPermissions(true);
		
			return Redirect::intended('/');
		} else {
			return Redirect::to('/cmauth/login')
				->withInput(Input::except('password'))
				->withErrors(['You have entered wrong username and password']);
		}         
	}
	
	public function getLogout() {
		Auth::logout();
		return Redirect::to('/cmauth/login')->with('message', 'You have logged out');
	}	

	public function getYetkiyenile(){
		$this->permissionRefresher->refreshPermissions(true);
		return Redirect::to('/');
	}
	
	public function postChangepassword(){
		$validator = Validator::make(Input::all(), User::$change_password_rules);
	 
		if ($validator->passes()) {

			$user = User::findOrFail(Auth::user()->id);

			if (!Hash::check(Input::get('current_password'), $user->password))
			{ 
			   return Redirect::to('/cmauth/settings')->withErrors('Your have entered current password wrong.');
			}

			
			$user->password = Hash::make(Input::get('password'));
			$user->pwdchanged = 1;
			$user->save();

			Session::put('pwdchanged', 1);
		 
			return Redirect::to('/')->with('message', 'Password changed');
		} 
		else {
			return Redirect::to('/cmauth/settings')->withErrors($validator)->withInput();
		}
	}


	public function getSettings() {

		return $this->returnLayout('cmauth::pwdreset');
	}	
}



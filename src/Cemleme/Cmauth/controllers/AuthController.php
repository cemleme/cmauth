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

use Cemleme\Cmauth\managers\LDAP;

class AuthController extends BaseController {

	//protected $connection="mysqlauthdb";
	protected $permissionRefresher;

	public function __construct(\UserPermissionRefresher $permissionRefresher) { 
		$this->permissionRefresher = $permissionRefresher;

		$this->middleware('auth', ['except' => ['getLogin', 'postLogin']]); 
	}
	
	public function getIndex() {
		return $this->returnLayout('cmauth::dashboard');
	}
	
	public function getLogin() {
		return view(config('cmauth.loginview'));
	}

	protected function processLogin($user){
		$user->last_login = new DateTime();
    	$user->save();

    	$this->permissionRefresher->refreshPermissions(true);
	}
	
	public function postLogin(LDAP $ldap) {

		if(!$user = User::where('email', Input::get('email'))->first()){
 			return Redirect::to('/cmauth/login')
				->withInput(Input::except('password'))
				->withErrors(['There is no such user registered to the system']);
 		}
	
		$remember = (Input::has('remember')) ? true : false;

		if($user->ldap>0 && config('cmauth.ldap')){
			if($ldap->authenticate(strstr(Input::get('email'), '@', true), Input::get('password'))){
	 			Auth::login($user);
	 			/*
	 			//set remember me manually
				if ($remember)
				{
					Auth::createRememberTokenIfDoesntExist($user);
					Auth::queueRecallerCookie($user);
				}
	 			*/
	 			$this->processLogin($user);
	 			return Redirect::intended('/');

			}
			else{
 				return Redirect::to('/cmauth/login')
						->withInput(Input::except('password'))
						->withErrors([Session::get('ldap_error')]);
			}
		}
	
		if (Auth::attempt(array('email'=>Input::get('email'), 'password'=>Input::get('password')),$remember)) {
			$this->processLogin(Auth::user());
			return Redirect::intended('/');
		} 
		else {
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
		if(Auth::user()->ldap>0 && config('cmauth.ldap'))
			return Redirect::to('/')->with('message', 'As you are connected to '.config('app.title', 'main'). ' domain, you can not change your password from here.');
		
		return $this->returnLayout('cmauth::pwdreset');
	}	
}



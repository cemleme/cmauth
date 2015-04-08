<?php
namespace Cemleme\Cmauth;

use Session;
use Auth;
use Route;


use Cemleme\Cmauth\models\Permission;


class PermissionChecker {
	
	public function __construct(){

	}

	public function checkPermission($value){
		
		$this->checkAndGetSessionUserData();

		$groupNames=Session::get('userGroupNames');
		if(in_array('MAXADMIN',$groupNames)) return true;

		$permissionNames=Session::get('userPermissionNames');
		if(strpos(implode(",", $permissionNames), $value) !== false) return true;

		return false;
	}

	public function checkAndGetSessionUserData($forceRefresh=false){

		if($forceRefresh || !Session::has('userGroupNames') || !Session::has('userPermissionNames')){
			$user = Auth::user();
			$user->load('groups', 'groups.permissions');

			$i=0;
			$j=0;
			$userGroupNames[0]="";
			$userPermissionNames[0]="";

			foreach($user->groups as $group) {		
				$userGroupNames[$i++]=$group->name;
				foreach($group->permissions as $permission) {	
					$userPermissionNames[$j++]=$permission->ident;
				}
			}

			Session::put('userGroupNames', $userGroupNames);
			Session::put('userPermissionNames', $userPermissionNames);
			Session::put('username', $user->name);
			Session::put('useremail', $user->email);
			Session::put('pwdchanged', $user->pwdchanged);
		}
	}

	public function setActive($route, $class = 'active')
	{
		return (in_array($this->getControllerName(), $route)) ? $class : '';
	    //return (getControllerName() == $route) ? $class : '';
	}

	public function getControllerName(){
		$menu = Route::currentRouteAction();
		$controllerName="";
	  
		if(!$menu=="" && !$menu==null){
			$arr = explode("Controller", $menu, 2);
			$arr = explode("RC", $arr[0], 2);
			$arr = explode("\\", $arr[0]);
			$controllerName=strtolower($arr[count($arr)-1]);
		}
		
		return $controllerName;
	}

}
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
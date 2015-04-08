<?php

Route::filter('acl.permitted', function($route, $request, $value=""){
		
		if($value!=""){ 
			if(!PermissionChecker::checkPermission($value)) return App::abort(401, 'Unauthorized action.');
		}
});

Route::filter('evrak.permitted', function($route, $request, $value=""){
		
		if($value!=""){ 
			if(!ProjectPermissionChecker::checkPermission($value)) return App::abort(401, 'Unauthorized action.');
		}
});
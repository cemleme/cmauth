<?php

function Cmauth($permission){
	return PermissionChecker::checkPermission($permission);
}
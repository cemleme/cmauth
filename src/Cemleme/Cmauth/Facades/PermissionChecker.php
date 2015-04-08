<?php namespace Cemleme\Cmauth\Facades;

use Illuminate\Support\Facades\Facade;

class PermissionChecker extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'permissionchecker'; }

}
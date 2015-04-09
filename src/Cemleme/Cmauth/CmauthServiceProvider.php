<?php namespace Cemleme\Cmauth;

use Illuminate\Support\ServiceProvider;
use View;

class CmauthServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
      	//View::addLocation(base_path().'/Cemleme/Cmauth/views');
      	//View::addNamespace('cmauth', base_path().'/Cemleme/Cmauth/views');

        // Register 'permissionchecker' instance container to our permissionchecker object
        $this->app['permissionchecker'] = $this->app->share(function($app)
        {
            return new PermissionChecker;
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('PermissionChecker', 'Cemleme\Cmauth\Facades\PermissionChecker');
            $loader->alias('UserPermissionRefresher', config('cmauth.permissionRefresher'));
            $loader->alias('User', 'Cemleme\Cmauth\models\User');
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}

    public function boot()
    {
    	$this->loadViewsFrom(__DIR__.'/views', 'cmauth');
        include __DIR__ . '/filters.php';
        include __DIR__ . '/routes.php';

        $this->publishes([
		    __DIR__.'/config/cmauth.php' => config_path('cmauth.php'),
		]);
    }


}

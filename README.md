Cmauth is a Role Based Access Control Authentication package developed for <b>Laravel 5</b> applications.<br/>
You can creating unlimited Groups (Roles) and Permissions and assign your users to Groups.

Afterwards you can use your filters and facades to check if the logged in user has proper permission for the current route / controller / method / view part.

<hr/>

<h3>Features:</h3>

<ul>
	<li>Creating and managing Users, Groups (Roles) and Permissions</li>
	<li>Managing login / logout / remember steps</li>
	<li>Permissions checks with filters and facades</li>
	<li>Option to choose different users to have passwords on the system or check credentials through LDAP</li>
	<li>Cmauth admin panel to assign users and permissions to groups</li>
</ul>

<hr/>

<h3>Requirements:</h3>

<ul>
	<li>Laravel 5</li>
	<li>PHP ldap extension (if you require LDAP authentication)</li>
</ul>

<hr/>

<h3>Setup:</h3>

In the require key of composer.json file add the following

"cemleme/cmauth": "dev-master"

Run the Composer update comand 

$ composer update cemleme/cmauth

In your config/app.php add 'Zizaco\Confide\ServiceProvider' to the end of the providers array

'providers' => [
    ...
    'Cemleme\Cmauth\CmauthServiceProvider',
],

At the end of config/app.php add <b>'User'</b> and <b>'UserPermissionRefresher'</b> to the aliases array

'aliases' => [
	...
    'UserPermissionRefresher' => 'Cemleme\Cmauth\managers\UserPermissionRefresher',
    'User' => 'Cemleme\Cmauth\models\User'
],

If you want your User model to have additional features, simply create your User model and extend '\Cemleme\Cmauth\models\User'


namespace App;

class User extends \Cemleme\Cmauth\models\User {

You can then set User alias as 'User' => '\App\User' (or whatever your namespace is)


Assign same User model at config/auth.php

'model' => 'Cemleme\Cmauth\models\User'  (or \App\User if you extend it)


Publish config file config/cmauth.php using artisan publish command:

php artisan vendor:publish --provider="Cemleme\Cmauth\CmauthServiceProvider"


<hr/>

<h3>Cmatuh Config File:</h3>

'mastertemplate' : The template you want to wrap Cmauth admin panel. It looks for @yield('content') at the template page
'loginview' => Your desired login page. Cmauth is compatible with default Laravel 5 login page. You do not need any extra fields.
'ldap' => Optional. Set it to true if you want to use LDAP authentication
'ldap_domain' => Required if 'ldap' => true. Your LDAP domain name  
'ldap_server' => Required if 'ldap' => true. IP address of your LDAP server
'ldap_port' => Required if 'ldap' => true. Port of your LDAP server
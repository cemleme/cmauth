<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmauthTables extends Migration {

	public function up()
	{
		Schema::create('users', function($table)
		{
			$table->increments('id');
			$table->string('name', 60);
			$table->string('email', 100)->unique();
			$table->tinyInteger('ldap')->default(0);
			$table->string('password', 64);
			$table->text('remember_token')->nullable();
			$table->tinyInteger('welcomesent');
			$table->tinyInteger('pwdchanged');
			$table->tinyInteger('permissionchanged')->default(0);
			$table->timestamp('last_login');
			$table->timestamp('last_activity');
			$table->timestamps();
		});
	
		Schema::create('cmauth_groups', function ($table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('description', 255);
        });
		
        Schema::create('cmauth_permissions', function ($table) {
 
            $table->increments('id');
            $table->string('name', 255);
            $table->string('description', 255);
 
        });

        Schema::create('cmauth_group_user', function ($table) {
 
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('cmauth_groups')->onDelete('cascade');
 
        });

        Schema::create('cmauth_group_permission', function ($table) {
 
            $table->integer('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('cmauth_groups')->onDelete('cascade');
            $table->integer('permission_id')->unsigned();
            $table->foreign('permission_id')->references('id')->on('cmauth_permissions')->onDelete('cascade');
 
        });		

        Schema::create('password_resets', function(Blueprint $table)
		{
			$table->string('email')->index();
			$table->string('token')->index();
			$table->timestamp('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
		Schema::drop('cmauth_groups');
		Schema::drop('cmauth_permissions');
		Schema::drop('cmauth_group_user');		
		Schema::drop('cmauth_group_permission');	
		Schema::drop('password_resets');	
	}

}

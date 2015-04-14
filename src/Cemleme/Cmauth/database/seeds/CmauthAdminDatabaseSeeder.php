<?php

use CEMLEME\Auth\models\User;
use CEMLEME\Auth\models\Group;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CmauthAdminDatabaseSeeder extends Seeder {

public function run()
	{
		Model::unguard();

		$this->initAdminUserAndGroup();
	}

	public function initAdminUserAndGroup(){
		$user = new User;
		$user->name = "Admin";
		$user->email = "admin@admin.com";
		$user->password = Hash::make("admin");
		$user->save();

		$group = new Group;
		$group->name = "MAXADMIN";
		$group->description = "Global Admin";
		$group->save(); 

		$user->groups()->attach($group->id);
	}

}

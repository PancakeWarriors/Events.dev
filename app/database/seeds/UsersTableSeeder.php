<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder {

	public function run()
	{
        $this->createEnvUser();
        $this->createFakeUsers();
	}

    protected function createEnvUser()
    {
	       $user = new User();
	       $user->email = $_ENV['USER_EMAIL'];
	       $user->password = $_ENV['USER_PASS']; 
	       $user->password_confirmation = $_ENV['USER_PASS']; 
	       $user->first_name = $_ENV['USER_FIRST_NAME'];
	       $user->last_name  = $_ENV['USER_LAST_NAME'];
	       $user->save();

    }

	protected function createFakeUsers()
	{
		$faker = Faker::create();


		for($i=0; $i<20; $i++)
		{
			$user = new User();
			$user->email = $faker->unique()->email();
			$user->password = "me";
			$user->password_confirmation = "me";
			$user->first_name = $faker->firstName();
			$user->last_name = $faker->lastName(); 
			$user->save();	

		}
	}

}
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
    	try{
	       $user = new User();
	       $user->first_name = $_ENV['USER_FIRST_NAME'];
	       $user->last_name  = $_ENV['USER_LAST_NAME'];
	       $user->email = $_ENV['USER_EMAIL'];
	       $user->password = $_ENV['USER_PASS']; 
	       $user->save();
	    }
	    catch(Exception $e){
	       // do task when error
	       echo $e->getMessage();   // insert query
	    }
    }

	protected function createFakeUsers()
	{
		$faker = Faker::create();


		for($i=0; $i<20; $i++)
		{
			$user = new User();
			$user->email = $faker->unique()->email();
			$user->password = $faker->password;
			$user->first_name = $faker->firstName();
			$user->last_name = $faker->lastName(); 
			$user->save();	

		}
	}

}
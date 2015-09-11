<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class LocationsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		for($i=0; $i<20; $i++)
		{
			$location = new Locations();
			$location->title = $faker->text(20);
			$location->address = $faker->streetAddress();
			$location->city = $faker->city();
			$location->state = $faker->stateAbbr();
			$location->zip = $faker->randomNumber($nvDigits = 5); 
			$location->save();	

		}
	}

}
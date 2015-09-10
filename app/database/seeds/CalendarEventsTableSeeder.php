<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class CalendarEventsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		for($i=0; $i<20; $i++)
		{
			$calendarEvent = new CalendarEvent();
			$calendarEvent->start_dateTime = $faker->dateTime($format = 'Y-m-d H:i:s');
			$calendarEvent->end_dateTime = $faker->dateTime($format = 'Y-m-d H:i:s');
			$calendarEvent->title = $faker->text(100);
			$calendarEvent->description = $faker->text(255);
			$calendarEvent->price = $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500);
		}
	}

}
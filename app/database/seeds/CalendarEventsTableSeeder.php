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
			$calendarEvent->start_dateTime = $faker->date($format = 'Y-m-d H:i:s');
			$calendarEvent->end_dateTime = $faker->date($format = 'Y-m-d H:i:s');
			$calendarEvent->title = $faker->text(100);
			$calendarEvent->description = $faker->text(255);
			$calendarEvent->user_id = $faker->numberBetween($min = 1, $max = 10);
			$calendarEvent->location_id = $faker->numberBetween($min = 1, $max = 10);
			$calendarEvent->price = $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500);
			$calendarEvent->image_url = "image.jpeg";
			$calendarEvent->save();
		}
	}

}
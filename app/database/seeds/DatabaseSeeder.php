<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		DB::table('users')->delete();
		DB::table('calendar_events')->delete();
		$this->call('UsersTableSeeder');
		$this->call('CalendarEventsTableSeeder');
	}

}

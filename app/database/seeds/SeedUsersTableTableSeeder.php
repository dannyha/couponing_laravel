<?php

class SeedUsersTableTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		DB::table('admins')->truncate();

		$users = [
            [
                'user_id' => 'ethorn',
                'first_name' => 'Emily',
                'last_name' => 'Thorn',
                'email' => 'emily.thorn@gmail.com',
                'password' => Hash::make('emilythorn'),
                'role' => 'user'
            ],
            [
                'user_id' => 'fjackson',
                'first_name' => 'Fred',
                'last_name' => 'Jackson',
                'email' => 'fred.jackson@gmail.com',
                'password' => Hash::make('fredjackson'),
                'role' => 'user'
            ],
            [
                'user_id' => 'dha',
                'first_name' => 'Danny',
                'last_name' => 'Ha',
                'email' => 'dha@olson.com',
                'password' => Hash::make('test123'),
                'role' => 'administrator'
            ],
            [
                'user_id' => 'cwong',
                'first_name' => 'Chris',
                'last_name' => 'Wong',
                'email' => 'cwong@olson.com',
                'password' => Hash::make('test123'),
                'role' => 'administrator'
            ]
        ];

        foreach($users as $user){
            User::create($user);
        }


	}

}

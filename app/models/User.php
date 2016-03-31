<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'admins';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	//protected $hidden = array('password', 'remember_token');

	public static $addUserRules = [	
				            	'user_id' => 'required',
				            	'first_name' => 'required',
				            	'last_name' => 'required',
				                'email' => 'required|email|min:8',
				                'role' => 'required',
				                'password' => 'required'
				            ];


	protected $fillable = ['user_id', 'first_name', 'last_name', 'email', 'role', 'password'];

}

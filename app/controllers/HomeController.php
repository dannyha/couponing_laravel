<?php

class HomeController extends BaseController {

	protected $layout = 'layouts.master';
	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function loginPage()
	{

		return View::make('login');

	}


	public function showWelcome()
	{

		$data = [
            'content' => Lang::get('validation')
        ];
		return View::make('home', $data);

	}


	public function setLanguage()
	{

		$input = Input::all();
		$lang = (isset($input['language'])) ? $input['language'] : 'en';
		App::setLocale($lang);
		Session::put('my.locale', $lang);
		return $lang;

	}

	public function getLanguage()
	{

		return Session::get('my.locale', Config::get('app.locale'));

	}


}

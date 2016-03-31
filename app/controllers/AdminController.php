<?php

class AdminController extends BaseController {

    /**
     * Show the login page.
     *
     * @return void
     */
    public function login()
    {
        return View::make('admin.login');
    }


    /**
     * Handle Login.
     *
     * @return void
     */
    public function handleLogin()
    {
        $data = Input::only(['email', 'password']);

        $validator = Validator::make(
            $data,
            [
                'email' => 'required|email|min:8',
                'password' => 'required',
            ]
        );

        $invalidCombination = [
            'password' => 'Email/Password combination is invalid'
        ];

        if($validator->fails())
        {
            return Redirect::to('admin')->withErrors($validator)->withInput();
        } 
        else 
        {
            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']]))
            {
                return Redirect::to('dashboard');
            }
            else
            {
                return Redirect::to('admin')->withErrors($invalidCombination)->withInput();
            }   
        }
    }


    /**
     * Show all coupon statistic(s).
     *
     * @return void
     */
    public function dashboard()
    {
        $couponStatistics = CouponStatistic::all();
    
        return View::make('admin.dashboard')->with('couponStatistics',$couponStatistics);

    }

    /**
     * Logout out.
     *
     * @return void
     */
    public function logout()
    {
        if(Auth::check())
        {
            Auth::logout();
        }

        return Redirect::to('admin');
    }

     /**
     * Show the form for creating a new user.
     *
     * @return Response
     */
    public function addUser()
    {
        return View::make('admin.addUser');
    }

    /**
     * Store a newly created user.
     *
     * @return Response
     */
    public function saveUser()
    {
        $input = Input::only(['user_id','first_name','last_name','email','role','password']);

        $validation = Validator::make($input,User::$addUserRules);

        if($validation->fails())
        {
            return Redirect::back()->withInput()->withErrors($validation->messages());
        }

        $createUser = User::firstOrCreate([
            'user_id' => Input::get('user_id'),
            'first_name' => Input::get('first_name'),
            'last_name' => Input::get('last_name'),
            'email' => Input::get('email'),
            'role' => Input::get('role'),
            'password' => Hash::make(Input::get('password')),
        ]);

        return View::make('admin.saveUser')->with('createUser',$createUser);

    }

}
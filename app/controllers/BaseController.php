<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	protected function auth($userId)
	{
		$accessToken = Request::header('Janrain-Access-Token');

	    $user = Users::where('user_id',$userId)->first();

	    if($user)
        {
        	if($accessToken == $user->access_token)
            {
                return 'true';
            }
            else
            {
                return 'false';
            }
       }
       else
       {
       		return 'user does not exist';
       }
        
	}

}

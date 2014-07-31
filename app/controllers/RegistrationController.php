<?php

use Illuminate\Support\Facades\Input;

class RegistrationController extends \BaseController {

    public function __construct()
    {
        $this->beforeFilter('guest');
    }

	/**
	 * Show a form to register the user.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('registration.create');
	}

	/**
	 * Create a new forum member.
	 *
	 * @return Response
	 */
	public function store()
	{
        $rules = [
            'username' => 'required|min:6|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6'
        ];

        $validator = Validator::make(Input::only('username', 'email', 'password', 'password_confirmation'), $rules);

        if($validator->fails())
        {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $confirmation_code = str_random(30);

        User::create([
            'username' => Input::get('username'),
            'email' => Input::get('email'),
            'password' => Hash::make(Input::get('password')),
            'confirmation_code' => $confirmation_code
        ]);

        Mail::send('emails.verify', compact('confirmation_code'), function($message) {
            $message->to(Input::get('email'), Input::get('username'))->subject('Verify your email address');
        });

        Flash::message('Thanks for signing up! Please check your email and follow the instructions to complete the sign up process');

        return Redirect::home();
    }

    /**
     * Attempt to confirm a users account.
     *
     * @param $confirmation_code
     *
     * @throws InvalidConfirmationCodeException
     * @return mixed
     */
    public function confirm($confirmation_code)
    {
        if( ! $confirmation_code)
        {
            return Redirect::home();
        }

        $user = User::whereConfirmationCode($confirmation_code)->first();

        if ( ! $user)
        {
            return Redirect::home();
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        Flash::message('You have successfully verified your account. You can now login.');

        return Redirect::route('login_path');
    }
}

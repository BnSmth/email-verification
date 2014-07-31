<?php

class SessionsController extends \BaseController {

    public function __construct()
    {
        $this->beforeFilter('guest', ['except' => ['destroy']]);
        $this->beforeFilter('auth', ['only' => ['destroy']]);
    }

	/**
	 * Show the login form.
	 * GET /sessions/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('sessions.create');
	}

	/**
	 * Attempt to log a user in
	 * POST /sessions
	 *
	 * @return Response
	 */
	public function store()
	{
        $rules = [
            'username' => 'required|exists:users',
            'password' => 'required'
        ];

        $validator = Validator::make(Input::only('username', 'email', 'password'), $rules);

        if($validator->fails())
        {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $credentials = [
            'username' => Input::get('username'),
            'password' => Input::get('password'),
            'confirmed' => 1
        ];

        if ( ! Auth::attempt($credentials))
        {
            return Redirect::back()->withInput()->withErrors(['credentials' => 'We were unable to sign you in']);
        }

        Flash::message('Welcome back!');

        return Redirect::home();
	}

	/**
	 * Log a user out
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{
		Auth::logout();
        return Redirect::home();
	}

}
<?php
namespace App\Http\Controllers;

use Validator;
use View;
use Redirect;
use Neodigital\Forum\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Neodigital\Forum\ForumUser;
use Neodigital\Forum\Session\ViewTemplate;

class RegisterController extends Controller {

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

	public function index()
	{
		return View::make('register');
	}
	
	public function registerAction(Request $r)
	{
		$rules = array(
			'username' 			=> 'required|max:20|unique:users',
			'fullname' 			=> 'required|max:100',
			'email' 			=> 'required|email|unique:users',
			'retype_email' 		=> 'required|email|same:email',
			'password' 			=> 'required|min:8',
			'retype_password' 	=> 'required|min:8|same:password',
			'gender' 			=> 'required',
			'bd_days' 			=> 'required',
			'bd_month' 			=> 'required',
			'bd_year' 			=> 'required',
		);
		$validator = Validator::make($r->all(), $rules);
		if($validator->fails())
		{
			return Redirect::back()->withErrors($validator->errors())->withInput();
		}
		else
		{
			$data	= array(
				'username' 			=> Input::get('username'),
				'fullname' 			=> Input::get('fullname'),
				'remember_token' 	=> Input::get('_token'),
				'email' 			=> Input::get('email'),
				'retype_email' 		=> Input::get('retype_email'),
				'password' 			=> Input::get('password'),
				'retype_password' 	=> Input::get('retype_password'),
				'gender' 			=> Input::get('gender'),
				'bd_days' 			=> Input::get('bd_days'),
				'bd_month' 			=> Input::get('bd_month'),
				'bd_year' 			=> Input::get('bd_year'),
			);
			if(ForumUser::RegisterUser($data))
			{
				Email::SendRegister(Input::get('email'));
				return Redirect::to('register-success');
			}
			
		}
	}

	public function registerSuccess()
	{
		ViewTemplate::$viewname	= 'success';
		return View::make('register');
	}

	public function fbset($i)
	{
		return Redirect::to('register-fb')->with('email',$i);
	}

	public function fb()
	{
		ViewTemplate::$viewname	= 'facebook';
		return View::make('register');
	}

	public function registerfbAction(Request $r)
	{
		$rules = array(
			'username' 			=> 'required|max:20|unique:users',
			'email' 			=> 'required|email|unique:users',
			'retype_email' 		=> 'required|email|same:email',
			'password' 			=> 'required|min:8',
			'retype_password' 	=> 'required|min:8|same:password',
		);
		$validator = Validator::make($r->all(), $rules);
		if($validator->fails())
		{
			return Redirect::back()->withErrors($validator->errors())->withInput();
		}
		else
		{
			$data	= array(
				'username' 			=> Input::get('username'),
				'fullname' 			=> '',
				'remember_token' 	=> Input::get('_token'),
				'email' 			=> Input::get('email'),
				'retype_email' 		=> Input::get('retype_email'),
				'password' 			=> Input::get('password'),
				'retype_password' 	=> Input::get('retype_password'),
				'gender' 			=> '',
				'bd_days' 			=> '',
				'bd_month' 			=> '',
				'bd_year' 			=> '',
			);
			if(ForumUser::RegisterUser($data))
			{
				Email::SendRegister(Input::get('email'));
				return Redirect::to('register-success');
			}

		}
	}

}

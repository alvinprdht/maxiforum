<?php
namespace App\Http\Controllers;

use Auth;
use Redirect;
use Validator;
use View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Neodigital\Forum\ForumUser;
use Neodigital\Forum\User\ProfileImage;
use Neodigital\Forum\User\Privacy;
use Neodigital\Forum\Session\ViewTemplate;

class UserController extends Controller {

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

	function __construct()
	{

	}

	public function index($i = '')
	{
		//ViewTemplate::$viewname	= 'index';
		ViewTemplate::$viewname	= 'about';
		ViewTemplate::$passvar	= $i;
		return View::make('profile');
	}

	public function activities($i = '')
	{
		ViewTemplate::$viewname	= 'activities';
		ViewTemplate::$passvar	= $i;
		return View::make('profile');
	}

	public function editprofile()
	{
		ViewTemplate::$viewname	= 'edit-profile';
		return View::make('profile');
	}
	
	public function saveprofile(Request $r)
	{
		$rules = array(
			'fullname' 			=> 'required|max:100',
			'gender' 			=> 'required',
			'bd_days' 			=> 'required',
			'bd_month' 			=> 'required',
			'bd_year' 			=> 'required',
			'biography' 		=> 'max:255',
			'address' 			=> 'max:255',
		);
		$validator = Validator::make($r->all(), $rules);
		if($validator->fails())
		{
			return Redirect::back()->withErrors($validator->errors())->withInput();
		}
		else
		{
			$data	= array(
				'fullname' 			=> Input::get('fullname'),
				'gender' 			=> Input::get('gender'),
				'birthdate' 		=> Input::get('bd_year').'-'.Input::get('bd_month').'-'.Input::get('bd_days'),
				'biography' 		=> Input::get('biography'),
				'address' 			=> Input::get('address'),
			);
			if(ForumUser::UpdateProfileUser($data))
			{
				if ($r->hasFile('profileimage')) {

					$rules = array(
						'profileimage' => 'mimes:jpeg,jpg,png,gif|required|max:500kb'
					);
					$validator = Validator::make($r->all(), $rules);
					if($validator->fails())
					{
						return Redirect::back()->withErrors($validator->errors())->withInput();
					}
					else
					{
						ProfileImage::UploadProfilePicture(Input::file('profileimage'));
					}

				}

				//return Redirect::back()->with('message','Profile Updated');
				return Redirect::to('user/profile/'.Auth::user()->user_id);
			}
			
		}
	}

	public function changepassword()
	{
		ViewTemplate::$viewname	= 'change-password';
		return View::make('profile');
	}

	public function savechangepassword(Request $r)
	{
		if(Hash::check(Input::get('password_old'), Auth::user()->password))
		{
			$rules = array(
				'password_new' => 'required|min:8',
				'retype_password_new' => 'required|min:8|same:password_new',
			);
			$validator = Validator::make($r->all(), $rules);
			if ($validator->fails()) {
				return Redirect::back()->withErrors($validator->errors())->withInput();
			} else {

				$data = array(
					'password' => bcrypt(Input::get('password_new')),
				);
				if (ForumUser::UpdatePasswordUser($data)) {
					return Redirect::back()->with('message','Password Changed !');
				}
			}
		}
		else
		{
			return Redirect::back()->withErrors(array('wrongoldpass'=>'Wrong Old Password'));
		}
	}

	public function privacy()
	{
		Privacy::makeUserPrivacy(Auth::user()->user_id);
		ViewTemplate::$viewname	= 'privacy';
		return View::make('profile');
	}

	public function updateprivacy(Request $r)
	{
		$data	= array(
			'name'		=> Input::get('privacy_fullname'),
			'gender'	=> Input::get('privacy_gender'),
			'email'		=> Input::get('privacy_email'),
			'birthdate'	=> Input::get('privacy_birthdate'),
		);
		Privacy::updateDatePrivacyUser($data);
		return Redirect::back()->with('message', 'Privacy Updated !');
	}

	public function about($i = '')
	{
		ViewTemplate::$passvar	= $i;
		ViewTemplate::$viewname	= 'about';
		return View::make('profile');
	}

	public function forumpost($i = '')
	{
		ViewTemplate::$passvar	= $i;
		ViewTemplate::$viewname	= 'forum-post';
		return View::make('profile');
	}

	public function forumthread($i = '')
	{
		ViewTemplate::$passvar	= $i;
		ViewTemplate::$viewname	= 'forum-thread';
		return View::make('profile');
	}
}

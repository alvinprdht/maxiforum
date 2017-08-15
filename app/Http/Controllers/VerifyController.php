<?php

namespace App\Http\Controllers;

use View;
use Auth;
use Validator;
use Image;
use File;
use DB;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class VerifyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($a)
    {
        if($a == 'updatepassword')
        {
            return view::make('message.changepassword');
        }
        else
        {
            $user   = DB::table('user')
                ->select('id_user')
                ->where(DB::raw('md5(id_user)'), '=', $a)
                ->first();
            $id_user    = $user->id_user;
            if(count($user) > 0)
            {
                DB::table('user')
                    ->where(DB::raw('md5(id_user)'), '=', $a)
                    ->update(['email_status' => '1']);
                Session::set('id_user', $id_user);
                return view::make('message.verified');
            }
        }
    }

    public function updatepassword(Request $r)
    {
        if(Input::get('password') == Input::get('password_confirm'))
        {
            $rules = array(
                'password'		    => 'required|min:8',
                'password_confirm'	=> 'required|min:8',
            );
            $validator	= Validator::make($r->all(), $rules);
            if($validator->fails())
            {
                return Redirect::back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                DB::table('user')
                    ->where('id_user', '=', Session::get('id_user'))
                    ->update(['password' => bcrypt(Input::get('password'))]);
                return Redirect::to('admin');
            }
        }
        else
        {
            return redirect::back()->with('message', 'Your password is not match');
        }
    }

}

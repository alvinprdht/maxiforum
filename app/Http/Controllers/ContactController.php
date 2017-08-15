<?php

namespace App\Http\Controllers;

use View;
use DB;
use Validator;
use Session;
use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Neodigital\Blog\Language;
use Neodigital\Blog\Website;

class ContactController extends Controller
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
    public function index($i = '')
    {

        Language::index();
        Website::setPage('contact-us');
        Website::update_visitor('contact-us');

        $data   = array(
        );

        return View::make('contact', $data);

    }


    public function send(Request $r)
    {
        $rules = array(
            'name'		=> 'required|max:50',
            'email'		=> 'required|email',
            //'phone'		=> 'numeric|max:16',
            'subject'	=> 'required|max:50',
            'message'	=> 'required|min:50|max:500',
        );
        $validator	= Validator::make($r->all(), $rules);
		
		$phoneformat='';
		if(substr(Input::get('phone'), 0, 2) != '08')
		{
			$phoneformat = 'Nomor telepon harus diawali dengan 08';
		}
		
        if($validator->fails() || $phoneformat != '')
        {
            return Redirect::back()->withErrors($validator->errors())->withInput()->with('message', $phoneformat);
        }
        else
        {
            $contact            = new Contact;
            $contact->name      = Input::get('name');
            $contact->email     = Input::get('email');
            $contact->telp      = str_replace(' ', '', Input::get('phone'));
            $contact->subject   = Input::get('subject');
            $contact->message   = Input::get('message');
            $contact->save();
            return Redirect::back()->with('status_contact','success');
        }
    }




	
}

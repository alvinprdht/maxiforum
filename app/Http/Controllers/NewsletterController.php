<?php

namespace App\Http\Controllers;

use View;
use Auth;
use Validator;
use Image;
use File;
use Mail;
use Neodigital\Blog\Newsletter;

class NewsletterController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function thanksubscribe()
    {
        Mail::send('newsletter.thanksubscribe', ['user' => 'test'], function ($m) {
            $m->from('newsletter@maxiblogger.com', 'Maxiblogger');
            $m->to('final20.ap@gmail.com')->subject('Pemberitahuan Langganan Newsletter Maxiblogger');
        });
    }
}

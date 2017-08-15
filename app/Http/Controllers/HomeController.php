<?php

namespace App\Http\Controllers;

use Auth;
use File;
use Image;
use Session;
use Validator;
use View;
use Illuminate\Http\Request;
use Neodigital\Blog\PostLibrary;
use Neodigital\Blog\Poll;
use Neodigital\Blog\Ebook;
use Neodigital\Blog\AlbumRack;
use Neodigital\Blog\Language;
use Neodigital\Blog\AdsContainer;
use Neodigital\Blog\Newsletter;
use Neodigital\Blog\Website;

class HomeController extends Controller
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
    public function index()
    {
        Language::index();
        Website::setPage('home');
        Website::update_visitor('home');

        $postHeadline   = array(
            PostLibrary::getHeadLine(1),
            PostLibrary::getHeadLine(2),
            PostLibrary::getHeadLine(3),
            PostLibrary::getHeadLine(4),
        );

        if($postHeadline[0] == '' && $postHeadline[1] == '' && $postHeadline[2] == '' && $postHeadline[3] == '')
        {
            $postHeadline   = false;
        }

        $question    = Poll::getDataPoll('first');
        if(count($question) > 0)
        {
            $polling = array(
                'question' => $question,
                'answer' => Poll::getDataPollDetail($question->id_polling),
            );
        }
        else
        {
            $polling  = null;
        }


        $data   = array(
            'postHeadline'  => $postHeadline,
            'postVideo'     => PostLibrary::getVideoHome(),
            'postRecent'    => PostLibrary::getRecentPostHome(),
            'contentads'    => AdsContainer::getAds('850454'),
            'polling'       => $polling,
            'latestNews'    => PostLibrary::getLatestNewsHome(),
            'ebookModule'   => Ebook::getDataEbookHome(),
            'albumImages'   => AlbumRack::getDataAlbumHome(),
        );

        return View::make('home', $data);

    }

    public function submitPoll(Request $r)
    {
        return Poll::addAnswer($r);
        //return redirect::back();
        //return true;
    }

    public function requestNewsletter(Request $r)
    {
        $rules = array(
            'email' => 'required|email',
        );
        $validator = Validator::make($r->all(), $rules);
        if($validator->fails())
        {
            echo 'The email must be a valid email address.';
        }
        else
        {
            Newsletter::addParticipant($r);
            echo 'success';
        }
        //return redirect::back();
    }
	
	public function resultPoll()
	{
		return view('components.result-poll');
	}
	
	public function error()
	{
		return view('errors.500');
	}


	
}

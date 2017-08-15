<?php

namespace App\Http\Controllers;

use View;
use Auth;
use Validator;
use Image;
use File;
use Neodigital\Blog\PostLibrary;
use Neodigital\Blog\AdsContainer;
use Neodigital\Blog\Language;
use Neodigital\Blog\Website;

class AboutController extends Controller
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
        Website::setPage('about');
        Website::update_visitor('about');

        $data   = array(
            'recentPost'    => PostLibrary::getRecentPost(),
            'contentads'    => AdsContainer::getAds('402281'),
        );

        return View::make('about', $data);

    }

    public function privacyPolicy()
    {

        Language::index();
        Website::setPage('privacy-policy');
        Website::update_visitor('privacy-policy');

        return View::make('privacy-policy');

    }

    public function termCondition()
    {

        Language::index();
        Website::setPage('term-and-condition');
        Website::update_visitor('term-and-condition');

        return View::make('term-and-condition');

    }


	
}

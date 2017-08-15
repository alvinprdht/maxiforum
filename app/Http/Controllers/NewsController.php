<?php

namespace App\Http\Controllers;

use Neodigital\Blog\PostCategory;
use View;
use Auth;
use Validator;
use Image;
use File;
use Neodigital\Blog\PostLibrary;
use Neodigital\Blog\AlbumRack;
use Neodigital\Blog\Language;
use Neodigital\Blog\Website;

class NewsController extends Controller
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
        Website::setPage('news');
        Website::update_visitor('news');

        $data   = array(
            'category'      => 'News',
            'latestNews'    => PostLibrary::getLatestNewsCategory(1),
        );

        return View::make('category', $data);

    }


	
}

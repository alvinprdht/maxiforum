<?php

namespace App\Http\Controllers;

use View;
use Auth;
use Validator;
use Image;
use File;
use Neodigital\Blog\PostLibrary;
use Neodigital\Blog\AlbumRack;
use Neodigital\Blog\Language;
use Neodigital\Blog\Website;

class VideoController extends Controller
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
        Website::setPage('video');
        Website::update_visitor('video');

        $data   = array(
            'category'      => 'Video',
            'latestNews'    => PostLibrary::getLatestByVideo(),
            'albumImages'   => AlbumRack::getDataAlbumHome(),
        );

        return View::make('video', $data);

    }


	
}

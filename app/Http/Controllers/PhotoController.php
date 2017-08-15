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

class PhotoController extends Controller
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
        Website::setPage('photos');
        Website::update_visitor('photos');

        $data   = array(
            'category'      => 'Photos',
            'albumImages'   => AlbumRack::getDataAlbumAll(),
            'page'          => 'home'
        );

        return View::make('photos', $data);

    }

    public function detail($i)
    {

        Language::index();
        Website::setPage('photos');
        Website::update_visitor('photos');

        $data   = array(
            'category'      => 'Photos',
            'albumImages'   => AlbumRack::getDataAlbumAll($i),
            'page'          => 'detail'
        );

        return View::make('photos', $data);

    }

    public function photo($i, $j)
    {

        Language::index();
        Website::setPage('photos');
        Website::update_visitor('photos');

        $data   = array(
            'category'      => 'Photos',
            'data'          => AlbumRack::getDataAlbumImages($i, $j),
            'page'          => 'photos'
        );

        return View::make('photos', $data);

    }


	
}

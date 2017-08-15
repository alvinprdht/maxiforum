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
use Neodigital\Blog\PostCategory;

class CategoryController extends Controller
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

        $categoryName   = PostCategory::getCategory($i)->content_category;

        Language::index();
        Website::setPage('category');
        Website::update_visitor('category '.$categoryName);

        $data   = array(
            'category'      => $categoryName,
            'latestNews'    => PostLibrary::getLatestByCategory($i),
            'albumImages'   => AlbumRack::getDataAlbumHome(),
        );

        return View::make('category', $data);

    }


	
}

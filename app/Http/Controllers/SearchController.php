<?php

namespace App\Http\Controllers;

use Auth;
use File;
use Image;
use Session;
use Validator;
use View;
use App\EbookModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Neodigital\Blog\PostLibrary;
use Neodigital\Blog\AlbumRack;
use Neodigital\Blog\Language;
use Neodigital\Blog\Website;
use Neodigital\Blog\Ebook;

class SearchController extends Controller
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
    public function index($search = '')
    {

        Language::index();
        Website::setPage('search');

        $search         = str_replace('-',' ',$search);
        $dataArtikel    = PostLibrary::findArticle($search);
        $dataEbook      = Ebook::findEbook($search);
        $dataTags       = PostLibrary::findArticleByTags($search);

        $data   = array(
            'key'           => $search,
            'dataArtikel'   => $dataArtikel,
            'dataEbook'     => $dataEbook,
            'dataTags'      => $dataTags,
        );

        return View::make('search', $data);

    }

    public function search(Request $r)
    {
        // $string = strtolower(Input::get('search'));
        // $string = str_replace(' ','-',$string);
		// return 'search/'.$string;
        //return Redirect::to('search/'.$string);
    }

    public function tags($tagsName = '')
    {

        Language::index();
        Website::setPage('tags');
        Website::update_visitor('tags');

        $data   = array(
            'tags'          => $tagsName,
            'latestNews'    => PostLibrary::getLatestByTags($tagsName),
            'albumImages'   => AlbumRack::getDataAlbumHome(),
        );

        return View::make('tags', $data);

    }

    public function publish($publishdate = '')
    {

        Language::index();
        Website::setPage('Artikel ');
        Website::update_visitor('tags');

        $data   = array(
            'publishdate'   => date('d F Y', strtotime($publishdate)),
            'latestNews'    => PostLibrary::getLatestByPublishDate(date('Y-m-d', strtotime($publishdate))),
            'albumImages'   => AlbumRack::getDataAlbumHome(),
        );

        return View::make('publish', $data);

    }

}

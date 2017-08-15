<?php

namespace App\Http\Controllers;

use View;
use Auth;
use Validator;
use Image;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redirect;
use Neodigital\Blog\PostLibrary;
use Neodigital\Blog\PostEditor;
use Neodigital\Blog\Language;
use Neodigital\Blog\AdsContainer;
use Neodigital\Blog\Website;
use Neodigital\Blog\CommentStock;
use Neodigital\Blog\NotificationController;

class ArticleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($i = '', $j = '')
    {

        Language::index();
        Website::setPage('article');
        Website::update_viewer($i);

        // if(count(PostLibrary::getPost($i))>0)
        // {
            $data   = array(
                'post'          => PostLibrary::getPost($i),
                'relatedArticle'=> PostLibrary::getRelatedPost($i),
                'recentPost'    => PostLibrary::getRecentPost(),
                'contentads'    => AdsContainer::getAds('402281'),
            );
            return View::make('article', $data);
        // }
        // else
        // {
            // return SELF::error();
        // }

    }

    public function comments(Request $r)
    {

        $rules = array(
            'content'   => 'required|string',
            'name'      => 'required|string',
            'email'     => 'required|email|string',
        );
        $validator = Validator::make($r->all(), $rules);
        if($validator->fails())
        {
			echo $validator->errors();
            // return Redirect::back()->withErrors($validator->errors())->withInput();
        }
        else
        {
			$notifComments	= Input::get('name').' as '.Input::get('email').' is comments a post "'.PostEditor::getDataPost(Input::get('id_post'))->title.'"';
			NotificationController::addNotification('comments', array(2,3),'', $notifComments);
            CommentStock::postComments($r);
            // return Redirect::back()->with('status', 'Komentar anda akan ditampilkan beberapa saat nanti !');
			echo 'success';
        }

    }

    public function share(Request $r)
    {
        echo Website::update_share(Input::get('id_postlanguage'));
    }

	public function error()
	{
		return view('errors.503');
	}


	
}

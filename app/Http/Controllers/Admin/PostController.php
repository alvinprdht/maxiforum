<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use View;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Neodigital\Blog\PostEditor;
use Neodigital\Blog\PostCategory;
use Neodigital\Blog\PostEditorHeadline;

class PostController extends Controller
{
    
	private $page	= 'post';
	
	public function index()
	{
		if(Auth::user()->isAdmin() || Auth::user()->isEditor())
		{
			$data	= array(
				'page'		=> 'post.editor',
				'data'		=> PostEditor::getDataPageEditor(),
				'category'	=> '',
			);
			return View::make('admin.template', $data);
		}
		else
		{
			$data	= array(
				'page'		=> SELF::view('contributor'),
				'data'		=> array(),
				'category'	=> '',
			);	
			return View::make('admin.template', $data);
		}
	}
	
	public function headline($i = '')
	{
		if($i != '')
		{
			$data	= array(
				'page'		=> SELF::view('headline.create'),
				'data'		=> PostEditor::getDataPost(),
				'position'	=> $i,
			);
			return View::make('admin.template', $data);
		}
		else
		{
			$data 	= array(
				'title_1' => PostEditorHeadline::getHeadlinePostByID(1),
				'title_2' => PostEditorHeadline::getHeadlinePostByID(2),
				'title_3' => PostEditorHeadline::getHeadlinePostByID(3),
				'title_4' => PostEditorHeadline::getHeadlinePostByID(4),
			);
			$data	= array(
				'page'		=> SELF::view('headline'),
				'data'		=> $data,
				'category'	=> PostCategory::getCategory(),
			);
			return View::make('admin.template', $data);
		}
	}
	
	public function view($data)
	{
		$data	= explode('.', $data);
		$page	= array('admin', $this->page);
		if(count($data) > 0)
		{
			foreach($data as $temp)
			{
				array_push($page, $temp);
			}
		}
		else
		{
			array_push($page, $data);
		}
		return $page;
	}
	
}

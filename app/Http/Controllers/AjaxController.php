<?php

namespace App\Http\Controllers;

use View;
use Auth;
use Validator;
use Image;
use Illuminate\Routing\Controller as BaseController;
use Neodigital\Blog\PostEditor;
use Neodigital\Blog\PostEditorAjax;

class AjaxController extends BaseController
{
	
	function index()
	{
		
		$data = array(
			'page' 	=> 'home',
			'sub'	=> '',
			'data'	=> ''
		);	
		return View::make('admin.template', $data);
		
	}
	
	function postDetailDraft($i)
	{
		$data	= array('data' => PostEditor::getDataDraftDetail($i));
		return View::make('admin.ajax.postdetaildraft', $data);
	}
	
	function postSearch($page = '', $c = '', $p = '', $t = '', $sort = '', $seq = '')
	{
		$data	= array(
			'data' 	=> PostEditorAjax::getDataPostSearch($page, $c, $p, $t, $sort, $seq),
			'page'	=> $page
			);
		return View::make('admin.ajax.postsearch', $data);
	}
	
	function postSearchCount($page = '', $c = '', $p = '', $t = '')
	{
		echo PostEditor::getCountPage(PostEditorAjax::getDataPostSearch_count($c, $p, $t));
	}

	function draftSearch($page = '', $s = '', $l = '', $t = '', $sort = '', $seq = '')
	{
		$data	= array(
			'data' 	=> PostEditorAjax::getDataDraftSearch($page, $s, $l, $t, $sort, $seq),
			'page'	=> $page
			);
		return View::make('admin.ajax.draftsearch', $data);
	}

	function draftSearchCount($page = '', $s = '', $l = '', $t = '')
	{
		echo PostEditorAjax::getCountPage(PostEditorAjax::getDataDraftSearch_count($s, $l, $t));
	}

	function reviewSearch($page = '', $c = '', $p = '', $s = '',$t = '', $sort = '', $seq = '')
	{
		$data	= array(
			'data' 	=> PostEditorAjax::getDataReviewSearch($page, $c, $p, $s, $t, $sort, $seq),
			'page'	=> $page
			);
		return View::make('admin.ajax.reviewsearch', $data);
	}

	function reviewSearchCount($page = '', $c = '', $p = '', $s = '',$t = '')
	{
		echo PostEditorAjax::getCountPage(PostEditorAjax::getDataReviewSearch_count($c, $p, $s, $t));
	}

	function adsSearch($page = '', $s = '',$t = '', $sort = '', $seq = '')
	{
		$data	= array(
			'data' 	=> PostEditorAjax::getDataAdsSearch($page, $s, $t, $sort, $seq),
			'page'	=> $page
			);
		return View::make('admin.ajax.adssearch', $data);
	}

	function adsSearchCount($page = '', $s = '',$t = '')
	{
		echo PostEditorAjax::getCountPage(PostEditorAjax::getDataAdsSearch_count($s, $t));
	}

	function pollSearch($page = '', $t = '', $sort = '', $seq = '')
	{
		$data	= array(
			'data' 	=> PostEditorAjax::getDataPollSearch($page, $t, $sort, $seq),
			'page'	=> $page
			);
		return View::make('admin.ajax.pollsearch', $data);
	}

	function pollSearchCount($page = '', $s = '',$t = '')
	{
		echo PostEditorAjax::getCountPage(PostEditorAjax::getDataAdsSearch_count($s, $t));
	}
	
	function ebookSearch($page = '', $t = '', $sort = '', $seq = '')
	{
		$data	= array(
			'data' 	=> PostEditorAjax::getDataEbookSearch($page, $t, $sort, $seq),
			'page'	=> $page
			);
		return View::make('admin.ajax.ebooksearch', $data);
	}

	function ebookSearchCount($page = '', $s = '',$t = '')
	{
		echo PostEditorAjax::getCountPage(PostEditorAjax::getDataEbookSearch_count($s, $t));
	}

}

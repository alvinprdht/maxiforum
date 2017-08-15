<?php
namespace App\Http\Controllers;

use Auth;
use Neodigital\Forum\Thread;
use Neodigital\Forum\Thread\Create;
use Redirect;
use Validator;
use View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Neodigital\Forum\Moderator\User;
use Neodigital\Forum\Session\ViewTemplate;
use Neodigital\Forum\Thread\Create as CreateThread;
use Neodigital\Forum\Thread\Subscribe as SubscribeThread;
use Neodigital\Forum\Thread\ThreadImage;
use Neodigital\Forum\ThreadReply;

class ForumController extends Controller
{

	function __construct()
	{
		//$this->middleware('auth');
	}

	public function index($i = '')
	{

		$sort	= 'active';
		if(isset($_GET['sort']))
			$sort	= $_GET['sort'];

		ViewTemplate::$viewname = 'index';
		ViewTemplate::$passvar = array('category_id' => $i, 'sort' => $sort);
		return View::make('forum');
	}

	public function create($i = '')
	{
		if(Auth::check())
		{
			$_SESSION['dir_id']	= md5(Auth::user()->user_id);

			ViewTemplate::$viewname = 'create';
			ViewTemplate::$passvar = $i;
			return View::make('forum');
		}
		else
		{
			return Redirect::to('auth/login');
		}
	}

	public function savecreatethread($i, Request $r)
	{
		$rules = array(
			'title' 			=> 'required',
			'content'			=> 'required|max:10000',
			'features_image' 	=> 'mimes:jpeg,jpg,png,gif|required|max:1000'
		);
		$validator = Validator::make($r->all(), $rules);
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator->errors())->withInput();
		}
		else
		{
			$validator = Validator::make($r->all(), $rules);
			if($validator->fails())
			{
				return Redirect::back()->withErrors($validator->errors())->withInput();
			}
			else
			{

				$data	= array(
					'title'		=> Input::get('title'),
					'content'	=> Input::get('content'),
					'category_id'=>Input::get('category'),
				);
				CreateThread::SaveNewThread($data);
				ThreadImage::UploadThreadImages(Input::file('features_image'));
				if(Input::get('subscribe') == '2')
					SubscribeThread::MakeNewSubscription(Thread::GetLatestThread());
				return Redirect::to('forum/create/'.$i.'/success');
			}
		}
	}

	public function successcreate($i)
	{
		ViewTemplate::$viewname = 'success';
		ViewTemplate::$passvar = $i;
		return View::make('forum');
	}

	public function thread($i, $j)
	{
		ViewTemplate::$viewname = 'thread';
		ViewTemplate::$passvar = array('category'=> $i, 'thread_id' => $j);
		return View::make('forum');
	}

	public function reply($i, $j = '')
	{
		if(Auth::check())
		{
			ViewTemplate::$viewname = 'reply';
			if($j == '')
				ViewTemplate::$passvar = $i;
			else
				ViewTemplate::$passvar = array('i'=>$i, 'j'=>$j);
			return View::make('forum');
		}
		else
		{
			return Redirect::to('auth/login');
		}
	}

	public function savedatareply($i, Request $r)
	{
		$rules = array(
			'content'	=> 'required|max:10000',
		);
		$validator = Validator::make($r->all(), $rules);
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator->errors())->withInput();
		}
		else
		{
			$GetByEncryptedIdThreadData	= Thread::GetByEncryptedIdThreadData($i);
			$data	= array(
				'title' => Input::get('title'),
				'content' => Input::get('content'),
				'thread_id' => $GetByEncryptedIdThreadData->thread_id,
			);
			ThreadReply::SaveReply($data);
			return Redirect::to('forum/'.$GetByEncryptedIdThreadData->category_id.'/'.md5($GetByEncryptedIdThreadData->thread_id));
		}
	}

	public function edit($i, $j = '')
	{
		if(Auth::check())
		{
			ViewTemplate::$viewname = 'edit';
			if($j == '')
				ViewTemplate::$passvar = $i;
			else
				ViewTemplate::$passvar = array('i'=>$i, 'j'=>$j);
			return View::make('forum');
		}
		else
		{
			return Redirect::to('auth/login');
		}
	}

	public function saveeditthread($i, Request $r)
	{
		$rules = array(
			'title' 			=> 'required',
			'content'			=> 'required|max:10000',
		);
		$validator = Validator::make($r->all(), $rules);
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator->errors())->withInput();
		}
		else
		{
			$GetByEncryptedIdThreadData	= Thread::GetByEncryptedIdThreadData($i);
			$data	= array(
				'thread_title' => Input::get('title'),
				'content' => Input::get('content'),
			);
			CreateThread::SaveEditThread($GetByEncryptedIdThreadData->thread_id ,$data);
			return Redirect::to('forum/'.$GetByEncryptedIdThreadData->category_id.'/'.md5($GetByEncryptedIdThreadData->thread_id));
		}
	}

	public function saveratethread($i, $j, $k)
	{
		if(Auth::check())
		{
			$data	= array(
				'thread_id' => $j,
				'value'		=> $k,
				'user_id'	=> Auth::user()->user_id
			);
			Thread::Rate($data);
			return Redirect::to('forum/'.$i.'/'.$j);
		}
		else
		{
			return Redirect::to('auth/login');
		}
	}

	public function subscribe($i)
	{
		if(Auth::check())
		{
			SubscribeThread::MakeByEncryptedIdNewSubscription($i);
			return Redirect::back()->with('message', 'Thread Subscribed !');
		}
		else
		{
			return Redirect::to('auth/login');
		}
	}

}

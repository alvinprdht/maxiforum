<?php
namespace App\Http\Controllers;

use Auth;
use Redirect;
use Validator;
use View;
use Neodigital\Forum\Session\ViewTemplate;
use Neodigital\Forum\DirectMessage;
use Neodigital\Forum\DirectMessage\Authentificate as DMAuth;
use Neodigital\Forum\ForumUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class DmController extends Controller
{

	function __construct()
	{
		$this->middleware('auth');
	}

	public function compose($i = '')
	{
		ViewTemplate::$viewname = 'compose';
		ViewTemplate::$passvar = $i;
		return View::make('dm');
	}

	public function sendmessage(Request $r)
	{
		$rules = array(
			'to' 	=> 'required',
			'title' => 'required|max:100',
			'body' 	=> 'required|max:1500',
		);
		$validator = Validator::make($r->all(), $rules);
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator->errors())->withInput();
		}
		else
		{
			$to	= explode(',', Input::get('to'));
			$list	= array();
			$error	= array();
			foreach($to as $temp)
			{
				$username	= str_replace(' ', '', $temp);
				$data	= ForumUser::GetDataByUsernameUser($username);
				if(count($data) > 0)
				{
					array_push($list, $data->user_id);
				}
				else
				{
					array_push($error, $temp);
				}
			}

			if(count($error) > 0)
			{
				$errormessage	= 'User with username : ';
				foreach($error as $temp)
				{
					$errormessage .= '"'.$temp.'", ';
				}
				$errormessage .= ' is not found !';
				return Redirect::back()->with('nfound', $errormessage)->withInput();
			}
			else
			{
				SELF::sendMultipleMessage($list, Input::get('title'), Input::get('body'));
				return Redirect::to('dm/success/1/sent');
			}
		}

	}

	public function success($i, $event)
	{
		if($event == 'sent')
		{
			ViewTemplate::$viewname = 'message.success-sent';
		}
		elseif($event == 'deleted')
		{
			ViewTemplate::$viewname = 'message.success-deleted';
		}
		ViewTemplate::$passvar = $i;
		return View::make('dm');
	}

	public function outbox()
	{
		ViewTemplate::$viewname = 'outbox';
		return View::make('dm');
	}

	public function inbox()
	{
		ViewTemplate::$viewname = 'inbox';
		return View::make('dm');
	}

	public function view($i)
	{
		if(!DMAuth::check('view',$i))
		{
			return Redirect::to('/notfound');
		}
		ViewTemplate::$viewname = 'view';
		ViewTemplate::$passvar 	= $i;
		return View::make('dm');
	}

	public function delete($i)
	{
		if(!DMAuth::check('delete',$i))
		{
			return Redirect::to('/notfound');
		}
		ViewTemplate::$viewname = 'delete';
		ViewTemplate::$passvar 	= $i;
		return View::make('dm');
	}

	public function updatedeletemessage($i, Request $r)
	{
		if(DirectMessage::Delete($i))
		{
			return Redirect::to('dm/success/'.$i.'/deleted');
		}

	}

	public function forward($i)
	{
		ViewTemplate::$viewname = 'forward';
		ViewTemplate::$passvar 	= $i;
		return View::make('dm');
	}

	public function sendforwardmessage($i, Request $r)
	{
		$rules = array(
			'to' 	=> 'required',
			'title' => 'required|max:100',
			'body' 	=> 'required|max:1500',
		);
		$validator = Validator::make($r->all(), $rules);
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator->errors())->withInput();
		}
		else
		{
			$to	= explode(',', Input::get('to'));
			$list	= array();
			$error	= array();
			foreach($to as $temp)
			{
				$username	= str_replace(' ', '', $temp);
				$data	= ForumUser::GetDataByUsernameUser($username);
				if(count($data) > 0)
				{
					array_push($list, $data->user_id);
				}
				else
				{
					array_push($error, $temp);
				}
			}

			if(count($error) > 0)
			{
				$errormessage	= 'User with username : ';
				foreach($error as $temp)
				{
					$errormessage .= '"'.$temp.'", ';
				}
				$errormessage .= ' is not found !';
				return Redirect::back()->with('nfound', $errormessage)->withInput();
			}
			else
			{
				SELF::sendMultipleMessage($list, Input::get('title'), Input::get('body'));
				return Redirect::to('dm/success/'.$i.'/sent');
			}
		}
	}

	public function reply($i)
	{
		ViewTemplate::$viewname = 'reply';
		ViewTemplate::$passvar 	= $i;
		return View::make('dm');
	}

	public function sendreplymessage($i, Request $r)
	{
		$rules = array(
			'title' => 'required|max:100',
			'body' 	=> 'required|max:1500',
		);
		$validator = Validator::make($r->all(), $rules);
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator->errors())->withInput();
		}
		else
		{
			$data	= ForumUser::GetDataByUsernameUser(Input::get('to'));
			$id		= $data->user_id;
			$data	= array(
				'user_id'	=> $id,
				'title'		=> Input::get('title'),
				'body'		=> Input::get('body'),
			);
			DirectMessage::send($data);
			return Redirect::to('dm/success/'.$i.'/sent');
		}
	}

	public function deletemultiple(Request $r)
	{
		$id		= Input::get('message_id');
		$list	= explode(',', $id);
		foreach($list as $id)
		{
			if($id != '')
				DirectMessage::Delete($id);
		}
		return Redirect::back()->with('message', 'Messages has deleted !');
	}

	public function markread(Request $r)
	{
		$id		= Input::get('message_id');
		$list	= explode(',', $id);
		foreach($list as $id)
		{
			if($id != '')
				DirectMessage::MarkAsReadMessageStatus($id);
		}
		return Redirect::back();
	}

	public function markunread(Request $r)
	{
		$id		= Input::get('message_id');
		$list	= explode(',', $id);
		foreach($list as $id)
		{
			if($id != '')
				DirectMessage::MarkAsUnreadMessageStatus($id);
		}
		return Redirect::back();
	}

	public static function sendMultipleMessage($list, $title, $body)
	{
		foreach($list as $id)
		{
			$data	= array(
				'user_id'	=> $id,
				'title'		=> $title,
				'body'		=> $body,
			);
			DirectMessage::send($data);
		}
	}

}

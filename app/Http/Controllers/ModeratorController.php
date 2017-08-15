<?php
namespace App\Http\Controllers;

use Auth;
use Neodigital\Forum\Moderator\Manage;
use Redirect;
use Validator;
use View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Neodigital\Forum\Moderator\User;
use Neodigital\Forum\Moderator\Thread;
use Neodigital\Forum\Moderator\ThreadPopular;
use Neodigital\Forum\Session\ViewTemplate;

class ModeratorController extends Controller
{

	function __construct()
	{
		$this->middleware('auth');
	}

	public function user($i = '')
	{
		ViewTemplate::$viewname = 'user.index';
		return View::make('moderator');
	}

	public function approveuser($i)
	{
		ViewTemplate::$viewname = 'user.unapproved';
		ViewTemplate::$passvar = $i;
		return View::make('moderator');
	}

	public function updateapprovaluser($i, Request $r)
	{
		User::ApproveUser($i);
		return Redirect::to('moderator/user')->with('message', 'User Approved !');
	}

	public function deleteuser($i)
	{
		ViewTemplate::$viewname = 'user.delete';
		ViewTemplate::$passvar = $i;
		return View::make('moderator');
	}

	public function updatedeleteuser($i, Request $r)
	{
		User::DeleteUser($i);
		return Redirect::to('moderator/user')->with('message', 'User Deleted !');
	}

	public function alluser()
	{
		ViewTemplate::$viewname = 'user.all';
		return View::make('moderator');
	}

	public function allbanneduser()
	{
		ViewTemplate::$viewname = 'user.banned.index';
		return View::make('moderator');
	}

	public function banneduser($i)
	{
		ViewTemplate::$viewname = 'user.banned.detail';
		ViewTemplate::$passvar = $i;
		return View::make('moderator');
	}

	public function updatebanneduser($i, Request $r)
	{
		$data	= array(
			'encrypteduser_id'	=> $i,
			'message'			=> Input::get('message'),
		);
		User::SetUserBan($data);
		return Redirect::to('moderator/user/all')->with('message', 'User Banned !');
	}

	public function unbanneduser($i)
	{
		ViewTemplate::$viewname = 'user.banned.disable';
		ViewTemplate::$passvar = $i;
		return View::make('moderator');
	}

	public function updateunbanneduser($i, Request $r)
	{
		$data	= array(
			'encrypteduser_id'	=> $i,
		);
		User::SetNoUserBan($data);
		return Redirect::to('moderator/user/banned')->with('message', 'User Unbanned !');
	}

	public function homemanage()
	{
		ViewTemplate::$viewname = 'manage.index';
		return View::make('moderator');
	}

	public function assignmoderator()
	{
		ViewTemplate::$viewname = 'manage.assign';
		return View::make('moderator');
	}

	public function setmoderator($i)
	{
		ViewTemplate::$viewname = 'manage.set';
		ViewTemplate::$passvar = $i;
		return View::make('moderator');
	}

	public function updatesetmoderator($i, Request $r)
	{
		Manage::AssignModerator($i, Input::get('category'));
		return Redirect::to('moderator/manage/assign');
	}

	public function unsetmoderator($i)
	{
		ViewTemplate::$viewname = 'manage.unset';
		ViewTemplate::$passvar = $i;
		return View::make('moderator');
	}

	public function updateunsetmoderator($i, Request $r)
	{
		Manage::UnassignModerator($i);
		return Redirect::to('moderator/manage/assign');
	}

	public function thread()
	{
		ViewTemplate::$viewname = 'thread.index';
		return View::make('moderator');
	}

	public function approvethread($i)
	{
		ViewTemplate::$viewname = 'thread.unapproved';
		ViewTemplate::$passvar = $i;
		return View::make('moderator');
	}

	public function updateapprovethread($i, Request $r)
	{
		Thread::Approve($i);
		return Redirect::to('moderator/thread')->with('message', 'Thread Approved !');
	}

	public function threadall()
	{
		ViewTemplate::$viewname = 'thread.all';
		return View::make('moderator');
	}

	public function rejectthread($i)
	{
		ViewTemplate::$viewname = 'thread.reject';
		ViewTemplate::$passvar = $i;
		return View::make('moderator');
	}

	public function updaterejectthread($i, Request $r)
	{
		Thread::Reject($i);
		return Redirect::to('moderator/thread')->with('message', 'Thread Rejected !');
	}

	public function closethread($i)
	{
		ViewTemplate::$viewname = 'thread.close';
		ViewTemplate::$passvar = $i;
		return View::make('moderator');
	}

	public function updateclosethread($i, Request $r)
	{
		Thread::Close($i);
		return Redirect::to('moderator/thread/all')->with('message', 'Thread Closed !');
	}

	public function reopenthread($i)
	{
		ViewTemplate::$viewname = 'thread.reopen';
		ViewTemplate::$passvar = $i;
		return View::make('moderator');
	}

	public function updatereopenthread($i, Request $r)
	{
		Thread::Reopen($i);
		return Redirect::to('moderator/thread/all')->with('message', 'Thread Re-opened !');
	}

	public function setpopularthread($i)
	{
		ViewTemplate::$viewname = 'thread.popular.set';
		ViewTemplate::$passvar = $i;
		return View::make('moderator');
	}

	public function updatepopularthread($i, Request $r)
	{
		Thread::Popular($i);
		return Redirect::to('moderator/thread/all')->with('message', 'Thread Set as Popular !');
	}

	public function unsetpopularthread($i)
	{
		ViewTemplate::$viewname = 'thread.popular.unset';
		ViewTemplate::$passvar = $i;
		return View::make('moderator');
	}

	public function updateunpopularthread($i, Request $r)
	{
		Thread::UnPopular($i);
		return Redirect::to('moderator/thread/all')->with('message', 'Thread Popular Removed !');
	}

	public function popularthread()
	{
		ViewTemplate::$viewname = 'thread.popular.index';
		return View::make('moderator');
	}

	public function movedownpopularposition($i)
	{
		ThreadPopular::movedown($i);
		return Redirect::back()->with('message', 'Category moved to '. $i + 1);
	}

	public function moveuppopularposition($i)
	{
		ThreadPopular::moveup($i);
		return Redirect::back()->with('message', 'Category moved to '. $i + 1);
	}

	public function stickythread($i)
	{
		ViewTemplate::$viewname = 'thread.sticky.set';
		ViewTemplate::$passvar = $i;
		return View::make('moderator');
	}

	public function updatesetstickythread($i, Request $r)
	{
		Thread::Sticky($i);
		return Redirect::to('moderator/thread/all')->with('message', 'Thread Sticked !');
	}

	public function removesticky($i)
	{
		ViewTemplate::$viewname = 'thread.sticky.unset';
		ViewTemplate::$passvar = $i;
		return View::make('moderator');
	}

	public function updateremovestickythread($i, Request $r)
	{
		Thread::UnsetSticky($i);
		return Redirect::to('moderator/thread/all')->with('message', 'Thread Stick Removed !');
	}

	public function deletethread($i)
	{
		ViewTemplate::$viewname = 'thread.delete.set';
		ViewTemplate::$passvar = $i;
		return View::make('moderator');
	}

	public function updatedeletethread($i)
	{
		Thread::Delete($i);
		return Redirect::to('moderator/thread/all')->with('message', 'Thread Deleted !');
	}

	public function threaddelete()
	{
		ViewTemplate::$viewname = 'thread.delete.index';
		return View::make('moderator');
	}

	public function undeletethread($i)
	{
		ViewTemplate::$viewname = 'thread.delete.unset';
		ViewTemplate::$passvar = $i;
		return View::make('moderator');
	}

	public function updateundeletethread($i)
	{
		Thread::Undelete($i);
		return Redirect::to('moderator/thread/delete')->with('message', 'Thread Restored !');
	}

	public function permanentdeletethread($i)
	{
		ViewTemplate::$viewname = 'thread.delete.permanent';
		ViewTemplate::$passvar = $i;
		return View::make('moderator');
	}

	public function updatepermanentdeletethread($i)
	{
		Thread::Permanentdelete($i);
		return Redirect::to('moderator/thread/delete')->with('message', 'Thread Permanently Deleted !');
	}

}

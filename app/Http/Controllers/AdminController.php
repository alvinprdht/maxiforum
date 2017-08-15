<?php

namespace App\Http\Controllers;

use View;
use Auth;
use Validator;
use File;
use Mail;
use Session;
use URL;
use App\PostHeadline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redirect;
use Neodigital\Blog\UserManagement;
use Neodigital\Blog\Profile;
use Neodigital\Blog\PostEditor;
use Neodigital\Blog\PostEditorAjax;
use Neodigital\Blog\CommentStock;
use Neodigital\Blog\PostCategory;
use Neodigital\Blog\PostEditorHeadline;
use Neodigital\Blog\Poll;
use Neodigital\Blog\Ebook;
use Neodigital\Blog\AlbumRack;
use Neodigital\Blog\AdsContainer;
use Neodigital\Blog\Statistic;
use Neodigital\Blog\SettingBlog;
use Neodigital\Blog\SystemMessage;
use Neodigital\Blog\ContactList;
use Neodigital\Blog\AdminConfig;
use Neodigital\Blog\LogHistory;
use Neodigital\Blog\NotificationController;
use Neodigital\Blog\Image as Images;

class AdminController extends BaseController
{

	function __constructor()
	{
		$this->middleware('auth');
	}

	function index()
	{
		$data = array(
			'page' => 'home',
			'sub' => '',
			'data' => ''
		);
		return View::make('admin.template', $data);
	}
	
	function activate($md_userid)
	{
		// if(UserManagement::userIsVerify($md_userid))
		// {
			$email	= UserManagement::getUserEmailByEncryptedID($md_userid);
			$data	= array(
				'page'	=> 'guest',
				'sub'	=> 'activate',
				'data' => array('email' => $email, 'md_userid' => $md_userid)
			);
			return View::make('admin.template', $data);
		// }
	}
	
	function activateAction($md_userid, Request $r)
	{
		// if(UserManagement::userIsVerify($md_userid))
		// {
			$rules = array(
				'password' => 'min:6|required|confirmed',
				'password_confirmation' => 'min:6|required'
			);
			$validator = Validator::make($r->all(), $rules);
			if($validator->fails())
			{
				return Redirect::back()->withErrors($validator->errors());
			}
			else
			{
				$email	= UserManagement::getUserEmailByEncryptedID($md_userid);
				UserManagement::updateEmailStatusByEmail($email, Input::get('password'));
				$data	= array(
					'page'	=> 'guest',
					'sub'	=> 'activate-success',
					'data' => ''
				);
				return View::make('admin.template', $data);
			}
		// }
		// else
		// {
			// $email	= UserManagement::getUserEmailByEncryptedID($md_userid);
			// $data	= array(
				// 'page'	=> 'guest',
				// 'sub'	=> 'activate',
				// 'data' => array('email' => $email, 'md_userid' => $md_userid)
			// );
			// return View::make('admin.template', $data);
		// }
	}
	
	function resetpassLoginAction(Request $r)
	{
		$to = Input::get('email');
		Mail::send('mail.user-resetpass', ['to' => $to, 'id_user' => UserManagement::getUserIdByEmail($to)], function ($m) use ($to) {
			$m->from('no-reply@motivasikaryawan.co.id', 'Motivasi Karyawan');
			$m->to($to)->subject('Click Here To Reset Your Password !');
		});
		$data	= array(
			'page'	=> 'guest',
			'sub'	=> 'reset-emailsend',
			'data' => ''
		);
		return View::make('admin.template', $data);
		
	}
	
	function resetpass($md_userid)
	{
		// if(UserManagement::userIsVerify($md_userid))
		// {
			$email	= UserManagement::getUserEmailByEncryptedID($md_userid);
			$data	= array(
				'page'	=> 'guest',
				'sub'	=> 'reset',
				'data' => array('email' => $email, 'md_userid' => $md_userid)
			);
			return View::make('admin.template', $data);
		// }
	}
	
	function resetpassAction($md_userid, Request $r)
	{
		// if(UserManagement::userIsVerify($md_userid))
		// {
			$rules = array(
				'password' => 'min:6|required|confirmed',
				'password_confirmation' => 'min:6|required'
			);
			$validator = Validator::make($r->all(), $rules);
			if($validator->fails())
			{
				return Redirect::back()->withErrors($validator->errors());
			}
			else
			{
				$email	= UserManagement::getUserEmailByEncryptedID($md_userid);
				UserManagement::resetPassword($email, Input::get('password'));
				$data	= array(
					'page'	=> 'guest',
					'sub'	=> 'reset-success',
					'data' => ''
				);
				return View::make('admin.template', $data);
			}
		// }
		// else
		// {
			// $email	= UserManagement::getUserEmailByEncryptedID($md_userid);
			// $data	= array(
				// 'page'	=> 'guest',
				// 'sub'	=> 'activate',
				// 'data' => array('email' => $email, 'md_userid' => $md_userid)
			// );
			// return View::make('admin.template', $data);
		// }
	}
	
	function statistic($sub = '', $i = '')
	{
		if($sub == 'visitor')
		{
			if($i != '')
			{
				$data	= array(
					'page'		=> 'statistic',
					'sub'		=> 'visitor-detail',
					'data'		=> Statistic::getVisitorHome($i),
				);
				return View::make('admin.template', $data);
			}
			else
			{
				$data	= array(
					'page'		=> 'statistic',
					'sub'		=> 'visitor',
					'data'		=> Statistic::getVisitorHome(),
				);
				return View::make('admin.template', $data);
			}
		}
		elseif($sub == 'viewers')
		{
			if($i != '')
			{
				$data = array(
					'page' => 'statistic',
					'sub' => 'viewers-detail',
					'data' => Statistic::getViewersHome($i),
				);
				return View::make('admin.template', $data);
			}
			else
			{
				$data = array(
					'page' => 'statistic',
					'sub' => 'viewers',
					'data' => Statistic::getViewersHome(),
				);
				return View::make('admin.template', $data);
			}
		}
		elseif($sub == 'viewers')
		{
			if($i != '')
			{
				$data = array(
					'page' => 'statistic',
					'sub' => 'viewers-detail',
					'data' => Statistic::getViewersHome($i),
				);
				return View::make('admin.template', $data);
			}
			else
			{
				$data = array(
					'page' => 'statistic',
					'sub' => 'viewers',
					'data' => Statistic::getViewersHome(),
				);
				return View::make('admin.template', $data);
			}
		}
		elseif($sub == 'share')
		{
			if($i != '')
			{
				$data = array(
					'page' => 'statistic',
					'sub' => 'share-detail',
					'data' => Statistic::getShareHome($i),
				);
				return View::make('admin.template', $data);
			}
			else
			{
				$data	= array(
					'page'		=> 'statistic',
					'sub'		=> 'share',
					'data'		=> Statistic::getShareHome(),
				);
				return View::make('admin.template', $data);
			}
		}
	}

	function post($sub = '', $i = '')
	{
		if(count(PostCategory::getCategory()) > 0)
		{
			AdminConfig::$pageContent	= $i;
			if($sub == 'editor')
			{
				$data	= array(
					'page'		=> 'post',
					'sub'		=> 'editor',
					'data'		=> PostEditor::getDataPageEditor(),
					'category'	=> '',
				);
				return View::make('admin.template', $data);
			}
			elseif($sub == 'category')
			{
				if($i == 'new')
				{
					$data	= array(
						'page'			=> 'post',
						'sub'			=> 'create-category',
						'data'			=> 'existing',
						'data_detail'	=> '',
					);
					return View::make('admin.template', $data);
				}
				else
				{
					if($i == '')
					{
						$data	= array(
							'page'		=> 'post',
							'sub'		=> 'category',
							'data'		=> PostCategory::getCategory(),
							'category'	=> '',
						);
						return View::make('admin.template', $data);
					}
					else
					{
						$data	= PostCategory::getCategory($i);
						if(count($data)>0)
						{
							$data	= array(
								'page'		=> 'post',
								'sub'		=> 'edit-category',
								'data'		=> PostCategory::getCategory($i),
								'category_id'=> $i,
							);
							return View::make('admin.template', $data);
						}
					}
				}
			}
			elseif($sub == 'headline')
			{
				if (Auth::user()->isAdmin() || Auth::user()->isEditor()) {
					if ($i != '') {
						if (PostEditorHeadline::getHeadlinePostByID($i)['id_postlanguage'] == '') {
							$data = array(
								'page' => 'post',
								'sub' => 'create-headline',
								'data' => PostEditorHeadline::getDataPost_noHeadline(),
								'position' => $i,
							);
							return View::make('admin.template', $data);
						} else {
							Return Redirect::to('admin/post/headline-edit/' . $i);
						}
					} else {
						$data = array(
							'title_1' => PostEditorHeadline::getHeadlinePostByID(1),
							'title_2' => PostEditorHeadline::getHeadlinePostByID(2),
							'title_3' => PostEditorHeadline::getHeadlinePostByID(3),
							'title_4' => PostEditorHeadline::getHeadlinePostByID(4),
						);
						$data = array(
							'page' => 'post',
							'sub' => 'headline',
							'data' => $data,
							'category' => PostCategory::getCategory(),
						);
						return View::make('admin.template', $data);
					}
				}

			}
			elseif($sub == 'headline-edit')
			{
				if (Auth::user()->isAdmin() || Auth::user()->isEditor())
				{
					if ($i != '') {
						$data = array(
							'page' => 'post',
							'sub' => 'edit-headline',
							'data' => PostEditorHeadline::getHeadlinePostByID($i),
							'position' => $i,
						);
						return View::make('admin.template', $data);
					}
				}
			}
			elseif($sub == 'headline-reposition')
			{
				if (Auth::user()->isAdmin() || Auth::user()->isEditor())
				{
					if ($i != '') {
						$data = array(
							'page' => 'post',
							'sub' => 'reposition-headline',
							'data' => PostEditorHeadline::getHeadlinePostByID($i),
							'position' => $i,
						);
						return View::make('admin.template', $data);
					}
				}
			}
			elseif($sub == 'headline-reposition')
			{
				if (Auth::user()->isAdmin() || Auth::user()->isEditor())
				{
					if($i != '')
					{
						$data	= array(
							'page'		=> 'post',
							'sub'		=> 'reposition-headline',
							'data'		=> PostEditorHeadline::getHeadlinePostByID($i),
							'position'	=> $i,
						);
						return View::make('admin.template', $data);
					}
				}
			}
			elseif($sub == 'headline-delete')
			{
				if (Auth::user()->isAdmin() || Auth::user()->isEditor())
				{
					if($i != '')
					{
						$dataRack 		= PostEditorHeadline::getHeadlinePostByID($i);

						$target_directory	= 'public/headline/';
						$oldfile	= $target_directory.$dataRack['img'];
						if(file_exists($oldfile) && $dataRack['img'] != '')
							unlink($oldfile);

						PostEditorHeadline::deleteHeadline($i);
						return Redirect::to('admin/post/headline');
					}
				}
			}
			elseif($sub == 'contributor')
			{
				$data	= array(
					'page'		=> 'post',
					'sub'		=> 'contributor',
					'data'		=> '',
					'category'	=> '',
				);
				return View::make('admin.template', $data);
			}
			elseif($sub == 'publish') {
				if (Auth::user()->isAdmin() || Auth::user()->isEditor())
				{
					AdminConfig::setBreadcumb('post-publish');
					$data = array(
						'page' => 'post',
						'sub' => 'publish',
						'data' => array('id' => PostEditor::getDataDraftLanguage('id'), 'en' => PostEditor::getDataDraftLanguage('en')),
						'category' => PostCategory::getCategory(),
					);
					return View::make('admin.template', $data);
				}
				else
				{
					return redirect('505');
				}
			}
			elseif($sub == 'hide')
			{
				if($i != '')
				{
					PostEditor::hideFromWebsite($i);
					return Redirect::to('admin/post')->with('status','Post Hidden !');
				}
			}
			elseif($sub == 'show')
			{
				if($i != '')
				{
					PostEditor::showToWebsite($i);
					return Redirect::to('admin/post')->with('status','Post is now visibled !');
				}
			}
			elseif($sub == 'new')
			{
				if($i == '')
				{
					return Redirect::to('admin/post/draft/'.PostEditor::createNewPost());
				}
				else
				{
					$data	= array(
						'page'		=> 'post',
						'sub'		=> 'draft',
						'data'		=> '',
					);
					return View::make('admin.template', $data);
				}
			}
			elseif($sub == 'draft')
			{
				if($i == '')
				{
					$data	= array(
						'page'			=> 'post',
						'sub'			=> 'draft-list',
						'data'			=> PostEditorAjax::getDataDraftSearch(1),
						'count_page'	=> PostEditorAjax::getCountPage(PostEditor::getDataDraft()),
					);
					return View::make('admin.template', $data);
				}
				else
				{
					AdminConfig::setBreadcumb('draft-new');
					$getDataDraft		= PostEditor::getDataDraft($i);
					$getDataDraftDetail	= PostEditor::getDataDraftDetail($i);
					if(count($getDataDraft) > 0)
					{
						if(PostEditor::AllowToEdited($i))
						{
							$data	= array(
								'page'			=> 'post',
								'sub'			=> 'draft',
								'data'			=> $getDataDraft,
								'data_detail'	=> $getDataDraftDetail,
							);
							return View::make('admin.template', $data);
						}
						else
						{
							$data	= array(
								'page'			=> 'error',
								'sub'			=> 'Not Allowed',
								'data'			=> array('title'=> 'Your Article Was Already Submitted', 'description' => 'You can only edit article whenever article is draft statused')
							);
							return View::make('admin.template', $data);
						}
					}
					else
					{
						return redirect('505');
					}
				}
			}
			elseif($sub == 'edit')
			{
				if($i == '')
				{
					return redirect('505');
				}
				else
				{
					if(Auth::user()->isAdmin() || Auth::user()->isEditor())
					{
						$getDataReviewEdit	= PostEditor::getDataReviewEdit($i);
						$getDataDraftDetail	= PostEditor::getDataDraftDetail($i);
						//if(count($getDataReviewEdit) > 0)
						//{
							if(PostEditor::AllowToReviewEdited($i))
							{
								$data	= array(
									'page'			=> 'post',
									'sub'			=> 'edit',
									'data'			=> $getDataReviewEdit,
									'data_detail'	=> $getDataDraftDetail,
								);
								return View::make('admin.template', $data);
							}
							elseif(PostEditor::AllowToEditPublished($i))
							{
								$data	= array(
									'page'			=> 'post',
									'sub'			=> 'edit-published-post',
									'data' 			=> array('id' => PostEditor::getDataDraftLanguage('id'), 'en' => PostEditor::getDataDraftLanguage('en')),
									'data_existing'	=> PostEditor::getDataPublishedPost($i),
									'data_detail'	=> $getDataDraftDetail,
									'category' => PostCategory::getCategory(),
								);
								return View::make('admin.template', $data);
							}
							else
							{
								$data	= array(
									'page'			=> 'error',
									'sub'			=> 'Not Allowed',
									'data'			=> array('title'=> 'Your Article Was Already Reviewed or Rejected', 'description' => 'You can only edit article whenever article is draft statused')
								);
								return View::make('admin.template', $data);
							}
						//}
						//else
						//{
							//return redirect('505');
						//}
					}
				}
			}
			elseif($sub == 'submit')
			{
				$getDataDraft	= PostEditor::getDataDraft($i);
				$getCategory	= PostCategory::getCategory();
				if(count($getDataDraft) > 0)
				{
					if(PostEditor::AllowToSubmited($i))
					{
						$data	= array(
							'page'			=> 'post',
							'sub'			=> 'submit',
							'data'			=> $getDataDraft,
							'category'		=> $getCategory,
						);
						return View::make('admin.template', $data);
					}
					else
					{
						$data	= array(
							'page'			=> 'error',
							'sub'			=> 'Not Allowed',
							'data'			=> array('title'=> 'You Cannot Submit This Article', 'description' => 'Please check your article mandatory (title, content or features images) before submit, or your article has already submitted or reviewed !')
						);
						return View::make('admin.template', $data);
					}
				}
				else
				{
					return redirect('505');
				}
			}
			elseif($sub == 'review')
			{
				if(Auth::user()->isAdmin() || Auth::user()->isEditor())
				{
					if($i == '')
					{
						$getDataReview	= PostEditor::getDataReview();
						$data	= array(
							'page'			=> 'post',
							'sub'			=> 'review-list',
							'data'			=> $getDataReview,
							'count_page'	=> PostEditorAjax::getCountPage(PostEditor::getDataReview()),
						);
						return View::make('admin.template', $data);
					}
					else
					{
						$getDataReview	= PostEditor::getDataReview($i);
						if(count($getDataReview) > 0)
						{
							$data	= array(
								'page'			=> 'post',
								'sub'			=> 'review',
								'data'			=> $getDataReview,
							);
							return View::make('admin.template', $data);
						}
						else
						{
							return redirect('505');
						}
					}
				}
				else
				{
					return redirect('505');
				}
			}
			elseif($sub == 'delete')
			{
				$data	= PostEditor::getDataDraft($i);
				if(Auth::user()->id_user == $data['id_user'])
				{
					PostEditor::deleteDataDraft($i);
					return Redirect::to('admin/post/draft')->with('status','Draft Deleted !');
				}
				else
				{
					$data	= array(
						'page'			=> 'error',
						'sub'			=> 'Not Allowed',
						'data'			=> array('title'=> 'You Cannot Delete This Article', 'description' => 'No Authorization')
					);
					return View::make('admin.template', $data);
				}
			}
			elseif($sub == 'view')
			{
				$data	= PostEditor::getDataDraft_View($i);
				if(Auth::user()->id_user == $data['id_user'])
				{
					$data	= array(
						'page'			=> 'post',
						'sub'			=> 'view',
						'data'			=> $data
					);
					return View::make('admin.template', $data);
				}
			}
			elseif($sub == 'approve')
			{
				if(Auth::user()->isAdmin() || Auth::user()->isEditor())
				{
					$getDataDraft	= PostEditor::getDataDraft_adminApproval($i);
					$getCategory	= PostCategory::getCategory();
					if(count($getDataDraft) > 0)
					{
						if(PostEditor::AllowToApprove($i))
						{
							$data	= array(
								'page'			=> 'post',
								'sub'			=> 'approve',
								'data'			=> $getDataDraft,
								'category'		=> $getCategory,
							);
							return View::make('admin.template', $data);
						}
						else
						{
							return redirect('505');
						}
					}
					else
					{
						return redirect('505');
					}
				}
				else
				{
					return redirect('505');
				}
			}
			elseif($sub == 'comments')
			{
				NotificationController::setSeenNotification('comments');
				if($i == 'all')
				{
					AdminConfig::setBreadcumb('post-comments-all');
					$data	= array(
						'page'			=> 'post',
						'sub'			=> 'comments-all',
						'data'			=> PostEditor::getDataPostWithComments(),
						'data_detail'	=> '',
					);
					return View::make('admin.template', $data);
				}
				elseif($i != '')
				{
					$data	= array(
						'page'			=> 'post',
						'sub'			=> 'comments-detail',
						'data'			=> CommentStock::getDataCommentsPerPost($i),
						'data_detail'	=> '',
					);
					AdminConfig::setBreadcumb('post-comments-detail');
					return View::make('admin.template', $data);
				}
				else
				{
					AdminConfig::setBreadcumb('post-comments');
					$data	= array(
						'page'			=> 'post',
						'sub'			=> 'comments',
						'data'			=> CommentStock::getDataCommentsNeedToApproved(),
						'data_detail'	=> '',
					);
					return View::make('admin.template', $data);
				}
			}
			elseif($sub == 'comments-reply')
			{
				AdminConfig::setBreadcumb('post-comments-reply');
				$data	= array(
					'page'			=> 'post',
					'sub'			=> 'comments-reply',
					'data'			=> CommentStock::getDataCommentsNeedToApproved($i),
				);
				return View::make('admin.template', $data);
			}
			elseif($sub == 'comments-delete')
			{
				AdminConfig::setBreadcumb('post-comments-delete');
				$data	= array(
					'page'			=> 'post',
					'sub'			=> 'comments-delete',
					'data'			=> CommentStock::getDataCommentsNeedToApproved($i),
				);
				return View::make('admin.template', $data);
			}
			elseif($sub == 'comments-approve')
			{
				CommentStock::approveComments($i);
				return redirect::back()->with('status','Comments Approved');
				//return View::make('admin.template', $data);
			}
			elseif($sub == 'comments-reject')
			{
				CommentStock::rejectComments($i);
				return redirect::back()->with('status','Comments Rejected');
				//return View::make('admin.template', $data);
			}
			elseif($sub == 'deletepost')
			{
				PostEditor::deletePublishedPost($i);
				return redirect::back()->with('status','Post Deleted !');
			}
			else
			{
				AdminConfig::setBreadcumb('post-home');
				$data	= array(
					'page'			=> 'post',
					'sub'			=> 'home',
					'data'			=> PostEditor::getDataPostSearch(),
					'commentAproval'=> CommentStock::getDataCommentsNeedToApproved(),
					'count_page'	=> PostEditorAjax::getCountPage(PostEditor::getDataPostSearch_count()),
					'data_detail'	=> '',
				);
				return View::make('admin.template', $data);
			}
		}
		else
		{
			$data	= array(
				'page'			=> 'post',
				'sub'			=> 'create-category',
				'data'			=> '',
				'data_detail'	=> '',
			);
			return View::make('admin.template', $data);
		}
	}

	function profile($sub = '')
	{
		if($sub == 'edit')
		{
			$data	= array(
				'page'		=> 'profile',
				'sub'		=> 'edit',
				'data'		=> '',
			);
			return View::make('admin.template', $data);
		}
		elseif($sub == 'crop')
		{
			$data	= array(
				'page'		=> 'profile',
				'sub'		=> 'crop',
				'data'		=> '',
			);
			return View::make('admin.template', $data);
		}
		else
		{
			if($sub	== '') $sub = Auth::User()->id_user;
			$data	= Profile::getDataProfile($sub);
			$data	= array(
				'page'		=> 'profile',
				'sub'		=> 'home',
				'data'		=> $data,
			);
			return View::make('admin.template', $data);
		}
	}

	function user($sub = 'home', $i = false)
	{
		if($sub == 'deleteuser')
		{
			UserManagement::deleteUser($i);
			return Redirect::back()->with('status','1 Field deleted');
		}
		elseif($sub == 'noactivateuser' || $sub == 'activateuser')
		{
			$active 	= '';
			$message	= '';
			if($sub == 'noactivateuser')
			{
				$message	= '1 Field has not activated';
				$active		= 0;
			}
			else
			{
				$message	= '1 Field has activated';
				$active 	= 1;
			}
			$data	= array(
				'id_user' => $i,
				'active' => $active
			);
			UserManagement::activateUser($data);
			return Redirect::to('admin/user')->with('status',$message);
		}
		elseif($sub == 'restore')
		{
			UserManagement::restoreUser($i);
			return Redirect::back()->with('status','1 Field restored');
		}
		elseif($sub == 'resetpass')
		{
			$email	= UserManagement::getUserEmailByEncryptedID($i);
			if($email != null)
			{
				$to = $email;
				Mail::send('mail.user-resetpass', ['to' => $to, 'id_user' => UserManagement::getUserIdByEmail($to)], function ($m) use ($to) {
					$m->from('no-reply@motivasikaryawan.co.id', 'Motivasi Karyawan');
					$m->to($to)->subject('Click Here To Reset Your Password !');
				});
			}
			return Redirect::back()->with('status','Password change sent !');
		}
		else
		{
			$data_user 	= array();
			if($sub == 'home' || $sub == '')
			{
				AdminConfig::setBreadcumb('user');
				$data_user	= UserManagement::getUserHome();
			}
			elseif($sub == 'unverified')
			{
				$data_user	= UserManagement::getUserHomeInactive();
			}
			elseif($sub == 'deleted')
			{
				$data_user	= UserManagement::getUserHomeDeleted();
			}
			elseif($sub == 'editaccount')
			{
				AdminConfig::setBreadcumb('user-edit');
				$data_user	= UserManagement::getDataUser($i);
			}
			elseif($sub == 'view')
			{
				$data_user	= UserManagement::getDataUser($i);
			}
			elseif($sub == 'new')
			{
				AdminConfig::setBreadcumb('user-new');
			}
			$data = array(
				'page' 	=> 'user',
				'sub' 	=> $sub,
				'data' 	=> $data_user
			);
			return View::make('admin.template', $data);
		}
	}

	function polling($sub = '', $i = '')
	{
		if(Auth::user()->isAdmin() || Auth::user()->isEditor())
		{
			if($sub	== 'new')
			{
				if($i == '')
				{
					return Redirect::to('admin/polling/draft/'.Poll::createNewQuestion());
				}
				else
				{
					return Redirect::to('admin/polling/');
				}
			}
			elseif($sub == 'result')
			{
				$data	= Poll::getDataPoll($i);
				if($data->status == '2')
				{
					$data	= array('data'=> Poll::getDataPoll($i),'data_detail' => Poll::getDataPollResultDetail($i));
					$data	= array(
						'page'			=> 'poll',
						'sub'			=> 'result',
						'data'			=> $data,
					);
					return View::make('admin.template', $data);
				}
				else
				{
					$data	= array(
						'page'			=> 'error',
						'sub'			=> 'Not Allowed',
						'data'			=> array('title'=> 'You Cannot See This Poll Result', 'description' => 'Poll result will be displayed after this poll is set to active poll on website')
					);
					return View::make('admin.template', $data);
				}
			}
			elseif($sub == 'active')
			{
				Poll::updateStatusPoll($i);
				if(Poll::getDataPoll($i)->status == 1)
				{
					return Redirect::to('admin/polling')->with('status','Polling Hidden !');
				}
				else
				{
					return Redirect::to('admin/polling')->with('status','Polling Displayed !');
				}
			}
			elseif($sub == 'delete')
			{
				Poll::deletePoll($i);
				return Redirect::to('admin/polling')->with('status','Polling Hidden !');
			}
			elseif($sub == 'draft')
			{
				if($i != '')
				{
					$data	= Poll::getDataPoll($i);
					if($data->status == '1')
					{
						$data	= array(
							'page'			=> 'poll',
							'sub'			=> 'draft',
							'data'			=> Poll::getDataPoll($i),
							'data_detail'	=> Poll::getDataPollDetail($i),
						);
						return View::make('admin.template', $data);
					}
					else
					{
						$data	= array(
							'page'			=> 'error',
							'sub'			=> 'Not Allowed',
							'data'			=> array('title'=> 'You Cannot Edit This Poll', 'description' => 'Please set this poll to inactive first to edit')
						);
						return View::make('admin.template', $data);
					}
				}
				else
				{
					return Redirect::to('admin/polling/');
				}
			}
			elseif($sub == 'crop')
			{
				if($i != '')
				{
					$data	= Poll::getDataPoll($i);
					if($data->status == '1')
					{
						$data	= array(
							'page'			=> 'poll',
							'sub'			=> 'crop',
							'data'			=> Poll::getDataPoll($i),
							'data_detail'	=> Poll::getDataPollDetail($i),
						);
						return View::make('admin.template', $data);
					}
					else
					{
						$data	= array(
							'page'			=> 'error',
							'sub'			=> 'Not Allowed',
							'data'			=> array('title'=> 'You Cannot Edit This Poll', 'description' => 'Please set this poll to inactive first to edit')
						);
						return View::make('admin.template', $data);
					}
				}
				else
				{
					return Redirect::to('admin/polling/');
				}
			}
			else
			{
				$data = array(
					'page' 			=> 'poll',
					'sub' 			=> 'home',
					'data'	 		=> Poll::getDataPoll(),
					'count_page'	=> PostEditorAjax::getCountPage(Poll::getDataPoll()),
				);
				return View::make('admin.template', $data);
			}
		}
		else
		{
			return redirect('505');
		}
	}

	function ebook($sub = '', $i = '')
	{
		if(Auth::user()->isAdmin() || Auth::user()->isEditor())
		{
			if($sub == 'upload')
			{
				$data = array(
					'page' 	=> 'ebook',
					'sub' 	=> 'upload',
					'data' 	=> array()
				);
				return View::make('admin.template', $data);
			}
			elseif($sub == 'thumbnails')
			{
				$data = array(
					'page' 	=> 'ebook',
					'sub' 	=> 'thumbnails',
					'data' 	=> Ebook::getDataEbook($i)
				);
				return View::make('admin.template', $data);
			}
			elseif($sub == 'thumbnails-crop')
			{
				$data = array(
					'page' 	=> 'ebook',
					'sub' 	=> 'thumbnails-crop',
					'data' 	=> Ebook::getDataEbook($i)
				);
				return View::make('admin.template', $data);
			}
			elseif($sub == 'hide')
			{
				Ebook::hideEbook($i);
				return Redirect::back()->with('status', 'Ebook hidden !');
			}
			elseif($sub == 'show')
			{
				Ebook::showEbook($i);
				return Redirect::back()->with('status', 'Ebook displayed !');
			}
			elseif($sub == 'delete')
			{
				Ebook::deleteEbook($i);
				return Redirect::back()->with('status', 'Ebook deleted !');
			}
			elseif($sub == 'view')
			{
				$data = array(
					'page' 	=> 'ebook',
					'sub' 	=> 'view',
					'data' 	=> Ebook::getDataEbook($i)
				);
				return View::make('admin.template', $data);
			}
			elseif($sub == 'edit')
			{
				$data = array(
					'page' 	=> 'ebook',
					'sub' 	=> 'edit',
					'data' 	=> Ebook::getDataEbook($i)
				);
				return View::make('admin.template', $data);
			}
			elseif($sub == 'download')
			{
				$data = array(
					'page' 	=> 'ebook',
					'sub' 	=> 'download',
					'data' 	=> Ebook::getDataEbookDownload($i)
				);
				return View::make('admin.template', $data);
			}
			else
			{
				$data = array(
					'page' 		=> 'ebook',
					'sub' 		=> 'home',
					'data' 		=> Ebook::getDataEbook(),
					'count_page'=> PostEditorAjax::getCountPage(Ebook::getDataEbook()),
				);
				return View::make('admin.template', $data);
			}
		}
	}

	function albums($sub = '', $i = '')
	{
		if(Auth::user()->isAdmin() || Auth::user()->isEditor())
		{
			if($sub == 'new')
			{
				$data = array(
					'page' 	=> 'album',
					'sub' 	=> 'new',
					'data' 	=> array()
				);
				return View::make('admin.template', $data);
			}
			elseif($sub == 'upload')
			{
				$data = array(
					'page' 	=> 'album',
					'sub' 	=> 'upload',
					'data' 	=> AlbumRack::getDataAlbum($i)
				);
				return View::make('admin.template', $data);
			}
			elseif($sub == 'hide')
			{
				AlbumRack::hideAlbum($i);
				return Redirect::back()->with('status', 'Album hidden !');
			}
			elseif($sub == 'show')
			{
				AlbumRack::showAlbum($i);
				return Redirect::back()->with('status', 'Album displayed !');
			}
			elseif($sub == 'delete')
			{
				AlbumRack::deleteAlbum($i);
				return Redirect::back()->with('status', 'Album deleted !');
			}
			elseif($sub == 'view')
			{
				$data = array(
					'page' 	=> 'album',
					'sub' 	=> 'view',
					'data' 	=> AlbumRack::getDataAlbumImages($i)
				);
				return View::make('admin.template', $data);
			}
			elseif($sub == 'thumbnails')
			{
				$data = array(
					'page' 	=> 'album',
					'sub' 	=> 'thumbnails',
					'data' 	=> AlbumRack::getDataAlbum($i)
				);
				return View::make('admin.template', $data);
			}
			elseif($sub == 'download')
			{

				$zip = new ZipArchive();
				if($zip->open('file.zip', false ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true)
				{
					return false;
				}
				//add the files
				//foreach($valid_files as $file) {
					//$zip->addFile($file,$file);
				//}
				//debug
				//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

				//close the zip -- done!
				$zip->close();

				//check to make sure the file exists
				return file_exists('file.zip');
			}
			elseif($sub == 'edit')
			{
				$data = array(
					'page' 	=> 'album',
					'sub' 	=> 'edit',
					'data' 	=> AlbumRack::getDataAlbum($i)
				);
				return View::make('admin.template', $data);
			}
			elseif($sub == 'preview')
			{
				$data   = array(
					'category'      => 'Photos',
					'albumImages'   => AlbumRack::getDataAlbumAll($i),
					'page'          => 'preview-album'
				);

				return View::make('admin.page.album.preview', $data);
			}
			elseif($sub == 'crop-image-thumbnails')
			{
				$data   = array(
					'page'          => 'album',
					'sub' 			=> 'crop-image-thumbnails',
					'data'          => AlbumRack::getDataImage($i),
				);

				return View::make('admin.template', $data);
			}
			elseif($sub == 'crop-album-thumbnails')
			{
				$data   = array(
					'page'          => 'album',
					'sub' 			=> 'crop-album-thumbnails',
					'data'          => AlbumRack::getDataImage($i),
				);

				return View::make('admin.template', $data);
			}
			elseif($sub == 'deleteimages')
			{
				echo AlbumRack::deleteImages($i);
			}
			else
			{
				$data = array(
					'page' 	=> 'album',
					'sub' 	=> 'home',
					'data' 	=> AlbumRack::getDataAlbum(),
					'count_page'=> PostEditorAjax::getCountPage(AlbumRack::getDataAlbum()),
				);
				return View::make('admin.template', $data);
			}
		}
	}

	function ads($sub = '', $i = '')
	{

		if(Auth::user()->isAdmin() || Auth::user()->isEditor())
		{
			if ($sub == 'new') {
				$data = array(
					'page' => 'ads',
					'sub'  => 'new',
					'data' => array()
				);
				return View::make('admin.template', $data);
			}
			elseif ($sub == 'edit') {
				$data = array(
					'page' => 'ads',
					'sub'  => 'edit',
					'data' => AdsContainer::getDataAds($i)
				);
				return View::make('admin.template', $data);
			}
			elseif ($sub == 'crop') {
				$data = array(
					'page' => 'ads',
					'sub'  => 'crop',
					'data' => AdsContainer::getDataAds($i)
				);
				return View::make('admin.template', $data);
			}
			elseif($sub == 'delete')
			{
				AdsContainer::deleteAds($i);
				return Redirect::back()->with('status', 'Ads deleted !');
			}
			else
			{
				$data = array(
					'page' 		=> 'ads',
					'sub' 		=> 'home',
					'data' 		=> AdsContainer::getDataAds(),
					'count_page'=> PostEditorAjax::getCountPage(AdsContainer::getDataAds()),
				);
				return View::make('admin.template', $data);
			}
		}
	}

	function contact($sub = '', $i = '')
	{
		if(Auth::user()->isAdmin() || Auth::user()->isEditor())
		{
			if ($sub == 'export') {
				$data = array(
					'page' 	=> 'contact',
					'sub' 	=> 'export',
					'data' 	=> array()
				);
				return View::make('admin.template', $data);
			}
			if ($sub == 'detail') {
				$data = array(
					'page' 	=> 'contact',
					'sub' 	=> 'detail',
					'data' 	=> ContactList::getContactByID($i)
				);
				return View::make('admin.template', $data);
			}
			else
			{
				$data = array(
					'page' 	=> 'contact',
					'sub' 	=> 'home',
					'data' 	=> ContactList::getContactAll()
				);
				return View::make('admin.template', $data);
			}
		}
	}

	function postAction($sub, $i = '', Request $r, $task = '')
	{
		if($sub == 'draft')
		{
			if($task == 'savedraft')
			{
				if(PostEditor::PostSaveDraft($i, $r))
				{
					return Redirect::to('admin/post/draft')->with('message','Content Saved');
				}
			}
			elseif($task == 'setfeatures')
			{
				$rules = array(
					'upload_images_features' => 'mimes:jpeg,jpg,png,gif|required|max:2500' // max 2500kb
				);
				$validator = Validator::make($r->all(), $rules);
				if($validator->fails())
				{
					return Redirect::to('admin/post/draft/'.$i)->withErrors($validator->errors());
				}
				else
				{
					$upload_images_features	= Input::file('upload_images_features');
					$filename = md5($i).'.'.$upload_images_features->getClientOriginalExtension();
					$destinationPath = 'features/'.date('Y').'/'.date('M');
					if(!File::isDirectory($destinationPath))
					{
						File::makeDirectory($destinationPath, 0775, true, true);
					}

					$target_file		= $destinationPath.'/'.$filename;
					move_uploaded_file($_FILES["upload_images_features"]["tmp_name"], $target_file);
					$filename	= '/'.date('Y').'/'.date('M').'/'.$filename;

					Images::resize(600, $target_file, $target_file);

					if(PostEditor::PostAddFeaturesImages($i, $filename))
					{
						return Redirect::to('admin/post/draft/'.$i)->with('message','Content Added');
					}
				}
			}
			elseif($task == 'addtext')
			{
				$rules = array(
					'textcontent' => 'required|string' // max 1000kb
				);
				$validator = Validator::make($r->all(), $rules);
				if($validator->fails())
				{
					echo $validator->errors();
					//return Redirect::to('admin/post/draft/'.$i.'#tab1')->withErrors($validator->errors())->withInput();
				}
				else
				{
					echo 'success';
					if(Input::get('detaildraft_id') == '')
					{
						if(PostEditor::PostAddText($i, $r))
						{
							//return Redirect::to('admin/post/draft/'.$i.'#tab1')->with('message','Content Added');
						}
					}
					else
					{
						if(PostEditor::PostEditText($i, $r))
						{
							//return Redirect::to('admin/post/draft/'.$i.'#tab1')->with('message','Content Edited');
						}
					}
				}
			}
			elseif($task == 'addimages')
			{
				$rules = array(
					'upload_images' => 'mimes:jpeg,jpg,png,gif|required|max:1000' // max 1000kb
				);
				$validator = Validator::make($r->all(), $rules);
				if($validator->fails())
				{
					echo $validator->errors();
					return Redirect::to('admin/post/draft/'.$i.'#tab2')->withErrors($validator->errors())->withInput();
				}
				else
				{
					$upload_images = Input::file('upload_images');
					$filename = time().md5(Auth::user()->id).'.'.$upload_images->getClientOriginalExtension();
					$destinationPath = 'postarticle/'.date('Y').'/'.date('M');
					if(!File::isDirectory($destinationPath))
					{
						File::makeDirectory($destinationPath, 0775, true, true);
					}
					$target_file		= $destinationPath.'/'.$filename;
					move_uploaded_file($_FILES["upload_images"]["tmp_name"], $target_file);

					Images::resize(600, $target_file, $target_file);

					if(Input::get('detaildraft_id') == '')
					{
						if(PostEditor::PostAddImages($i, $r, '/'.date('Y').'/'.date('M').'/'.$filename))
						{
							return Redirect::to('admin/post/draft/'.$i.'#tab2')->with('message','Content Added');
						}
					}
					else
					{
						$img_url	= PostEditor::GetFilenameByIdDetail(Input::get('detaildraft_id'));
						File::delete('postarticle'.$img_url->img_url);
						if(PostEditor::PostEditImages($i, $r, '/'.date('Y').'/'.date('M').'/'.$filename))
						{
							return Redirect::to('admin/post/draft/'.$i.'#tab2')->with('message','Content Edited');
						}
					}
				}
			}
			elseif($task == 'addvideo')
			{
				$rules = array(
					'video_link' => 'required|string',
					'video_description' => 'required|string',
				);
				$validator = Validator::make($r->all(), $rules);
				if($validator->fails())
				{
					return Redirect::to('admin/post/draft/'.$i.'#tab3')->withErrors($validator->errors())->withInput();
				}
				else
				{
					if(Input::get('detaildraft_id') == '')
					{
						PostEditor::PostAddVideo($i, $r);
						return Redirect::to('admin/post/draft/'.$i.'#tab3')->with('message','Content Added');
					}
					else
					{
						PostEditor::PostEditVideo($i, $r);
						return Redirect::to('admin/post/draft/'.$i.'#tab3')->with('message','Content Edited');
					}
				}
			}
			elseif($task == 'addquotes')
			{
				$rules = array(
					'quotes' 			=> 'required|string',
					'quotes_creator' 	=> 'required|string',
				);
				$validator = Validator::make($r->all(), $rules);
				if($validator->fails())
				{
					return Redirect::to('admin/post/draft/'.$i.'#tab4')->withErrors($validator->errors())->withInput();
				}
				else
				{
					if(Input::get('detaildraft_id_quotes') == '')
					{
						PostEditor::PostAddQuotes($i, $r);
						return Redirect::to('admin/post/draft/'.$i.'#tab4')->with('message','Content Added');
					}
					else
					{
						PostEditor::PostEditQuotes($i, $r);
						return Redirect::to('admin/post/draft/'.$i.'#tab4')->with('message','Content Added');
					}
				}
			}
			elseif($task == 'moveindex')
			{
				if(Input::get('move') == 'up')
				{
					PostEditor::PostMoveUp(Input::get('id_draftdetail'));
				}
				elseif(Input::get('move') == 'down')
				{
					PostEditor::PostMoveDown(Input::get('id_draftdetail'));
				}
			}
			elseif($task == 'delete')
			{
				PostEditor::PostDeleteDraft($i, Input::get('id_draftdetail'));
			}
		}
		
		elseif($sub == 'edit')
		{
			if($task == 'saveeditor')
			{
				if(PostEditor::PostSaveDraft($i, $r))
				{
					return Redirect::to('admin/post/edit')->with('message','Content Saved');
				}
			}
			elseif($task == 'setfeatures')
			{
				$rules = array(
					'upload_images_features' => 'mimes:jpeg,jpg,png,gif|required|max:1000' // max 1000kb
				);
				$validator = Validator::make($r->all(), $rules);
				if($validator->fails())
				{
					return Redirect::to('admin/post/edit/'.$i)->withErrors($validator->errors());
				}
				else
				{
					$upload_images_features	= Input::file('upload_images_features');
					$filename = md5($i).'.'.$upload_images_features->getClientOriginalExtension();
					$destinationPath = 'features/'.date('Y').'/'.date('M');
					if(!File::isDirectory($destinationPath))
					{
						File::makeDirectory($destinationPath, 0775, true, true);
					}
					
					$target_file		= $destinationPath.'/'.$filename;
					move_uploaded_file($_FILES["upload_images_features"]["tmp_name"], $target_file);
					$filename	= '/'.date('Y').'/'.date('M').'/'.$filename;

					Images::resize(600, $target_file, $target_file);

					if(PostEditor::PostAddFeaturesImages($i, $filename))
					{
						return Redirect::to('admin/post/edit/'.$i)->with('message','Content Added');
					}
				}
			}
			elseif($task == 'addtext')
			{
				$rules = array(
					'textcontent' => 'required|string' // max 1000kb
				);
				$validator = Validator::make($r->all(), $rules);
				if($validator->fails())
				{
					return Redirect::to('admin/post/edit/'.$i.'#tab1')->withErrors($validator->errors())->withInput();
				}
				else
				{
					if(Input::get('detaildraft_id') == '')
					{
						if(PostEditor::PostAddText($i, $r))
						{
							return Redirect::to('admin/post/edit/'.$i.'#tab1')->with('message','Content Added');
						}
					}
					else
					{
						if(PostEditor::PostEditText($i, $r))
						{
							return Redirect::to('admin/post/edit/'.$i.'#tab1')->with('message','Content Edited');
						}
					}
				}
			}
			elseif($task == 'addimages')
			{
				$rules = array(
					'upload_images' => 'mimes:jpeg,jpg,png,gif|required|max:1000' // max 1000kb
				);
				$validator = Validator::make($r->all(), $rules);
				if($validator->fails())
				{
					return Redirect::to('admin/post/edit/'.$i.'#tab2')->withErrors($validator->errors())->withInput();
				}
				else
				{
					$upload_images = Input::file('upload_images');
					$filename = time().md5(Auth::user()->id).'.'.$upload_images->getClientOriginalExtension();
					$destinationPath = 'postarticle/'.date('Y').'/'.date('M');
					if(!File::isDirectory($destinationPath))
					{
						File::makeDirectory($destinationPath, 0775, true, true);
					}
					$target_file		= $destinationPath.'/'.$filename;
					move_uploaded_file($_FILES["upload_images"]["tmp_name"], $target_file);

					Images::resize(600, $target_file, $target_file);

					if(Input::get('detaildraft_id') == '')
					{
						if(PostEditor::PostAddImages($i, $r, '/'.date('Y').'/'.date('M').'/'.$filename))
						{
							return Redirect::to('admin/post/edit/'.$i.'#tab2')->with('message','Content Added');
						}
					}
					else
					{
						$img_url	= PostEditor::GetFilenameByIdDetail(Input::get('detaildraft_id'));
						File::delete('postarticle'.$img_url->img_url);
						if(PostEditor::PostEditImages($i, $r, '/'.date('Y').'/'.date('M').'/'.$filename))
						{
							return Redirect::to('admin/post/edit/'.$i.'#tab2')->with('message','Content Edited');
						}
					}
				}
			}
			elseif($task == 'addvideo')
			{
				$rules = array(
					'video_link' => 'required|string',
					'video_description' => 'required|string',
				);
				$validator = Validator::make($r->all(), $rules);
				if($validator->fails())
				{
					return Redirect::to('admin/post/edit/'.$i.'#tab3')->withErrors($validator->errors())->withInput();
				}
				else
				{
					if(Input::get('detaildraft_id') == '')
					{
						PostEditor::PostAddVideo($i, $r);
						return Redirect::to('admin/post/draft/'.$i.'#tab3')->with('message','Content Added');
					}
					else
					{
						PostEditor::PostEditVideo($i, $r);
						return Redirect::to('admin/post/draft/'.$i.'#tab3')->with('message','Content Edited');
					}
				}
			}
			elseif($task == 'addquotes')
			{
				$rules = array(
					'quotes' 			=> 'required|string',
					'quotes_creator' 	=> 'required|string',
				);
				$validator = Validator::make($r->all(), $rules);
				if($validator->fails())
				{
					return Redirect::to('admin/post/edit/'.$i.'#tab4')->withErrors($validator->errors())->withInput();
				}
				else
				{
					if(Input::get('detaildraft_id_quotes') == '')
					{
						PostEditor::PostAddQuotes($i, $r);
						return Redirect::to('admin/post/edit/'.$i.'#tab4')->with('message','Content Added');
					}
					else
					{
						PostEditor::PostEditQuotes($i, $r);
						return Redirect::to('admin/post/edit/'.$i.'#tab4')->with('message','Content Added');
					}
				}
			}
			elseif($task == 'moveindex')
			{
				if(Input::get('move') == 'up')
				{
					PostEditor::PostMoveUp(Input::get('id_draftdetail'));
				}
				elseif(Input::get('move') == 'down')
				{
					PostEditor::PostMoveDown(Input::get('id_draftdetail'));
				}
			}
			elseif($task == 'delete')
			{
				PostEditor::PostDeleteDraft($i, Input::get('id_draftdetail'));
			}
		}
		elseif($sub == 'submit')
		{
			$rules = array(
				'spoiler' 			=> 'required|max:255',
			);
			$validator = Validator::make($r->all(), $rules);
			if($validator->fails())
			{
				return Redirect::to('admin/post/submit/'.$i)->withErrors($validator->errors())->withInput();
			}
			else
			{
				if(Auth::user()->isAdmin() || Auth::user()->isEditor())
				{
					PostEditor::PostUpdateApproval($i, $r);
					$data	= array(
						'page'			=> 'success',
						'sub'			=> 'submit',
						'data'			=> array(
							'title'			=> 'Your Article Has Been Submited !',
							'description' 	=> 'You can now publish your article',
							'target' 		=> URL::to('admin/post/review'),
						)
					);
					return View::make('admin.template', $data);
				}
				else
				{
					PostEditor::PostUpdateSubmit($i, $r);
					$data	= array(
						'page'			=> 'success',
						'sub'			=> 'submit',
						'data'			=> array(
							'title'			=> 'Your Article Has Been Submited',
							'description' 	=> 'Please wait for approval by Editor',
							'target' 		=> URL::to('admin/post/draft'),
						)
					);
					return View::make('admin.template', $data);
				}
			}
		}
		elseif($sub == 'approve')
		{
			$rules = array(
				'title' 	=> 'required|max:255',
				'spoiler' 	=> 'required|max:255',
			);
			$validator = Validator::make($r->all(), $rules);
			if($validator->fails())
			{
				return Redirect::to('admin/post/approve/'.$i)->withErrors($validator->errors())->withInput();
			}
			else
			{
				PostEditor::PostUpdateApproval($i, $r);
				return Redirect::to('admin/post/review')->with('message','Article Approved');
			}
		}
		elseif($sub == 'publish')
		{
			$rules = array(
				//'en'			=> 'required',
				'id'			=> 'required',
				'category'		=> 'required',
				'publish-date'	=> 'required|date'
			);
			$validator	= Validator::make($r->all(), $rules);
			if($validator->fails())
			{
				return Redirect::to('admin/post/publish')->withErrors($validator->errors())->withInput();
			}
			else
			{
				PostEditor::CreatePost($r);
				return Redirect::to('admin/post')->with('status','Post Published !');
			}
		}
		elseif($sub == 'publish-edit')
		{
			$rules = array(
				'id'			=> 'required',
				'category'		=> 'required',
				'publish-date'	=> 'required|date'
			);
			$validator	= Validator::make($r->all(), $rules);
			if($validator->fails())
			{
				return Redirect::to('admin/post/edit/'.Input::get('id_postlanguage'))->withErrors($validator->errors());
			}
			else
			{
				PostEditor::EditPost($r);
				return Redirect::to('admin/post')->with('status','Post Edited !');
			}
		}
		elseif($sub == 'category')
		{
			$rules = array(
				'category'		=> 'required|max:50',
			);
			$validator	= Validator::make($r->all(), $rules);
			if($validator->fails())
			{
				return Redirect::back()->withErrors($validator->errors())->withInput();
			}
			else
			{
				if($i == 'new')
				{
					PostCategory::CreateCategory($r);
				return Redirect::to('admin/post/category')->with('message','Content Added');
				}
				else
				{
					PostCategory::EditCategory($i, $r);
					return Redirect::to('admin/post/category')->with('message','Content Edited');
				}
			}
		}
		elseif($sub == 'headline')
		{
			$rules = array(
				'id_postlanguage'		=> 'required',
			);
			$validator	= Validator::make($r->all(), $rules);
			if($validator->fails())
			{
				return Redirect::back()->withErrors($validator->errors())->withInput();
			}
			else
			{
				PostEditorHeadline::CreateOrUpdateHeadline($r);
				Session::set('id_postlanguage', Input::get('id_postlanguage'));
				return Redirect::to('admin/post/headline-edit/'.Input::get('position'));
			}
		}
		elseif($sub == 'headline-edit')
		{
			$rules = array(
				'title'		=> 'required|max:255',
			);
			$validator	= Validator::make($r->all(), $rules);
			if($validator->fails())
			{
				return Redirect::back()->withErrors($validator->errors())->withInput();
			}
			else
			{
				PostEditorHeadline::updateTitle($i, Input::get('title'));
				return Redirect::to('admin/post/headline-edit/'.$i)->with('message','Title Updated !');
			}
		}
		elseif($sub == 'headline-reposition')
		{
			$dataRack 		= PostEditorHeadline::getHeadlinePostByID($i);
			$dataurlimage 	= Input::get('dataurlimage');
			if (strlen($dataurlimage) > 128) {
				list($ext, $data) = explode(';', $dataurlimage);
				list(, $data) = explode(',', $data);
				$data = base64_decode($data);

				$target_directory	= 'public/headline/';

				if (!file_exists($target_directory)) {
					mkdir($target_directory);
				}

				$oldfile	= $target_directory.$dataRack['img'];
				if(file_exists($oldfile) && $dataRack['img'] != '')
					unlink($oldfile);

				$filename		= time().'.jpg';
				$target_file 	= 'public/headline/'.$filename;

				file_put_contents($target_file, $data);
				PostEditorHeadline::updateImage($i, $filename);

				return Redirect::to('admin/post/headline-edit/'.$i)->with('message','Image Repositioned !');
			}
			else
			{
				echo 'son';
			}
		}
		elseif($sub == 'comments-reply')
		{
			$rules = array('content' =>'required');
			$validator	= Validator::make($r->all(), $rules);
			if($validator->fails())
			{
				return Redirect::back()->withErrors($validator->errors())->withInput();
			}
			else
			{
				//CommentStock::approveComments($i);
				CommentStock::replyComments($r, $i);
				//PostEditorHeadline::CreateOrUpdateHeadline($r);
				return Redirect::back()->with('status','Comment Replied !');
			}
		}
		elseif($sub == 'comments-delete')
		{
			CommentStock::rejectComments($i);
			return redirect::to('admin/post/comments/all')->with('status','Comments Deleted !');
		}
	}

	function profileAction($sub, Request $r)
	{
		if($sub == 'edit')
		{
			$rules = array(
				'first_name'	=> 'required',
				'last_name' 	=> 'required',
				'gender' 		=> 'required',
				// 'about' => 'required'
			);
			$validator = Validator::make($r->all(), $rules);
			if($validator->fails())
			{
				return Redirect::to('admin/profile/edit')->withErrors($validator->errors())->withInput();
			}
			else
			{
				UserManagement::editUserPersonal($r);
				if(Input::hasFile('profile_pic'))
				{
					if (Input::file('profile_pic')->isValid())
					{
						$profile_pic = Input::file('profile_pic');
						if(Auth::user()->photo == '')
							$filename = md5(Auth::user()->id_user).'.'.$profile_pic->getClientOriginalExtension();
						else
							$filename = Auth::user()->photo;
						$destinationPath = 'internal-user/avatars/original';
						$target_file	= $destinationPath.'/'.$filename;
						if(move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file))
						{
							UserManagement::uploadAvatarsUserPersonal($filename);
						}
					}
					return Redirect::to('admin/profile/edit')->with('crop','true');
				}
				else
				{
					return Redirect::to('admin/profile/edit')->with('status','Your Profile Have Been Updated !');
				}
			}
		}
		elseif($sub == 'edit-user')
		{
			$rules = array(
				'username' 		=> 'required|max:20',
			);
			$validator = Validator::make($r->all(), $rules);
			if($validator->fails())
			{
				return Redirect::to('admin/profile/edit')->withErrors($validator->errors())->withInput();
			}
			else
			{
				UserManagement::editUserAccountData(Input::get('username'));
				return Redirect::to('admin/profile/edit')->with('status','Your Profile Have Been Updated !');
			}
		}
		elseif($sub == 'editcrop')
		{
			$dataurlimage = Input::get('dataurlimage');
			if($dataurlimage != '')
			{
				try
				{
					if(strlen($dataurlimage) > 128) {
						list($ext, $data)   = explode(';', $dataurlimage);
						list(, $data)       = explode(',', $data);
						$data = base64_decode($data);
						$fileName = Auth::user()->photo;
						file_put_contents('internal-user/avatars/'.$fileName, $data);
						//$destinationPath = 'internal-user/avatars';
						//$img = Image::make('internal-user/avatars/'.$fileName);
						//$img->resize(140, 140);
						//$img->save($destinationPath.'/'.$fileName);
						//$target_file		= $destinationPath.'/'.$fileName;
						//move_uploaded_file($_FILES["upload_images_features"]["tmp_name"], $target_file);
					}
				}
				catch (\Exception $e) {
					$msg = $e;
				}
				return Redirect::to('admin/profile/edit')->with('status','Your Profile Have Been Updated !');
			}
			else
			{
				return Redirect::to('admin/profile/edit')->with('error','There an occured a problem during croping your image !');
			}
		}
	}

	function userAction($sub, Request $r)
	{
		if($sub == 'new')
		{
			$rules = array(
				'email' => 'required|email',
				// 'password' => 'required'
			);
			$validator = Validator::make($r->all(), $rules);
			if($validator->fails())
			{
				return Redirect::to('admin/user/new')->withErrors($validator->errors())->withInput();
			}
			else
			{
				LogHistory::createLog('user','create user',UserManagement::createUser($r));
				// if(Input::get('emailVerify') == 'on')
				// {
					$to = Input::get('email');
					Mail::send('mail.user-confirmation', ['to' => $to, 'id_user' => UserManagement::getUserIdByEmail($to)], function ($m) use ($to) {
						$m->from('no-reply@motivasikaryawan.co.id', 'Motivasi Karyawan');
						$m->to($to)->subject('Click Here To Activate Your Motivasi Karyawan Account !');
					});
					return Redirect::to('admin/user/new')->with('status', SystemMessage::getSuccess('new-user-email'));
				// }
				// else
				// {
					// return Redirect::to('admin/user/new')->with('status', SystemMessage::getSuccess('new-user'));
				// }
			}
		}
		elseif($sub == 'editaccount')
		{
			$rules = array(
				'username' => 'required|max:20'
			);
			$validator = Validator::make($r->all(), $rules);
			if($validator->fails())
			{
				return Redirect::to('admin/user/editaccount/'.Input::get('id_user'))->withErrors($validator->errors())->withInput();
			}
			else
			{
				UserManagement::editUserAccount($r);
				return Redirect::to('admin/user/editaccount/'.Input::get('id_user'))->with('status','This account has been updated');
			}

		}
		elseif($sub == 'resetpass')
		{
			$rules = array(
				'password' => 'min:6|required|confirmed',
				'password_confirmation' => 'min:6|required'
			);
			$validator = Validator::make($r->all(), $rules);
			if($validator->fails())
			{
				return Redirect::back()->withErrors($validator->errors());
			}
			else
			{
				$email	= UserManagement::getUserEmailByEncryptedID(Input::get('id_user'));
				UserManagement::updateEmailStatusByEmail($email, Input::get('password'));
				if($email != null)
				{
					$to = $email;
					Mail::send('mail.user-resetpass-admins', ['to' => $to, 'id_user' => UserManagement::getUserIdByEmail($to), 'new_pass' => Input::get('password')], function ($m) use ($to) {
						$m->from('no-reply@motivasikaryawan.co.id', 'Motivasi Karyawan');
						$m->to($to)->subject('[Admin] - We Have Updated Your New Password !');
					});
				}
				return Redirect::back()->with('status','Password change sent !');
			}
		}

	}

	function pollingAction($sub, $i = '', Request $r)
	{
		if(Auth::user()->isAdmin() || Auth::user()->isEditor())
		{
			if($sub == 'update')
			{
				Poll::updatePoll($i, $r, Poll::getDataPoll($i)->image);
			}
			elseif($sub == 'addanswer')
			{
				$rules = array(
					'pollanswer' => 'required|string' // max 1000kb
				);
				$validator = Validator::make($r->all(), $rules);
				if($validator->fails())
				{
					echo 'error';
				}
				else
				{
					if(Input::get('id_detail') == '')
					{
						echo Poll::addDetail($i, $r);
					}
					else
					{
						echo Poll::editDetail($r);
					}
				}
			}
			elseif($sub == 'deleteanswer')
			{
				Poll::deleteDetail($r);
			}
			elseif($sub == 'draft')
			{
				$rules = array(
					'pollquestion'	=> 'required|string',
					'desc'			=> 'required|string',
					'datefrom'		=> 'required|date',
					'dateto'		=> 'required|date',
					'images' 		=> 'mimes:jpeg,jpg,png,gif|max:5000' // max 1000kb
				);
				$validator = Validator::make($r->all(), $rules);
				if($validator->fails())
				{
					return Redirect::back()->withErrors($validator->errors())->withInput();
				}
				else
				{
					$filename	= '';
					$images		= Input::file('images');
					if ($images)
					{
						list($width, $height) = getimagesize($images) ;
						if($width == '630' && $height == '289')
						{
							$filename 		= time().'.'.$images->getClientOriginalExtension();
							$destinationPath = 'public/poll-images';
							$target_file		= $destinationPath.'/'.$filename;
							move_uploaded_file($_FILES["images"]["tmp_name"], $target_file);
						}
						else
						{
							$tmp_filename 			= time().'.'.$images->getClientOriginalExtension();
							$destinationPath 	= 'public/poll-images/temp';
							if (!file_exists($destinationPath)) {
								mkdir($destinationPath);
							}
							$target_file		= $destinationPath.'/'.$tmp_filename 			;
							move_uploaded_file($_FILES["images"]["tmp_name"], $target_file);
							session::set('crop_filename_poll', $tmp_filename);
							session::set('message_error','Your selected image size doesn\'t match with our polling image size !');
						}
					}
					else
					{
						$filename	= Poll::getDataPoll($i)->image;
					}
					if(count(Poll::getDataPollDetail($i)) == 0)
					{
						return Redirect::back()->with('counterror', 'Answer must be more than 1')->withInput();
					}
					else
					{
						if(Input::get('datefrom') > Input::get('dateto'))
						{
							return Redirect::back()->with('periodeerror', 'Start periode must be smaller')->withInput();
						}
						else
						{
							Poll::updatePoll($i, $r, $filename);
							return Redirect::to('admin/polling/draft/'.$i)->with('status','Polling Saved !');
						}
					}
				}
			}
			elseif ($sub == 'crop')
			{

				$dataurlimage = Input::get('dataurlimage');
				if($dataurlimage != '')
				{
					$destinationPath 	= 'public/poll-images';
					$filename			= Session::get('crop_filename_poll');
					try
					{
						if(strlen($dataurlimage) > 128)
						{
							list($ext, $data)   = explode(';', $dataurlimage);
							list(, $data)       = explode(',', $data);
							$data = base64_decode($data);
							$target_file		= $destinationPath.'/'.$filename;
							file_put_contents($target_file, $data);


							Images::resize(630, $target_file, $target_file);

							AdsContainer::editAdsFilename($i, $filename);
							unlink($destinationPath.'/temp/'.$filename);
							Poll::updatePollImages($i, $filename);
						}
					}
					catch (\Exception $e) {
						$msg = $e;
					}
					Session::forget('crop_filename_poll');
					Session::forget('message_error');
					return Redirect::to('admin/polling/draft/'.$i)->with('status','Poll Edited !');
				}
			}
		}
	}

	function ebookAction($sub = '', $i = '', Request $r)
	{
		if(Auth::user()->isAdmin() || Auth::user()->isEditor())
		{
			if($sub == 'upload')
			{
				$rules = array(
					'upload_modules'=> 'mimes:pdf|required|max:50000',
					'title'			=> 'required|string|max:255',
					'spoiler' 		=> 'required|string|max:255'
				);
				$validator = Validator::make($r->all(), $rules);
				if($validator->fails())
				{
					return Redirect::back()->withErrors($validator->errors())->withInput();
				}
				else
				{
					$upload_pdf			= Input::file('upload_modules');
					$filename			= time().'_'.str_replace(' ', '_', Input::get('title')).'.'.$upload_pdf->getClientOriginalExtension();
					$destinationPath 	= 'public/module/pdf';

					if (!file_exists($destinationPath)) {
						mkdir($destinationPath);
					}

					if ($upload_pdf->move($destinationPath, $filename))
					{
						$id = Ebook::saveModule($r, $filename);
						return Redirect::to('admin/ebook/thumbnails/'.$id)->with('status','Polling Saved !');
					}
				}
			}
			elseif($sub == 'edit')
			{
				$rules = array(
					'title'			=> 'required|string|max:255',
					'spoiler' 		=> 'required|string|max:255'
				);
				$validator = Validator::make($r->all(), $rules);
				if($validator->fails())
				{
					return Redirect::back()->withErrors($validator->errors())->withInput();
				}
				else
				{
					$filename	= Ebook::getDataEbook($i)->filename;
					if (Input::file('upload_modules'))
					{
						$upload_pdf			= Input::file('upload_modules');
						$filename			= time().'_'.str_replace(' ', '_', Input::get('title')).'.'.$upload_pdf->getClientOriginalExtension();
						$destinationPath 	= 'public/module/pdf';

						if (!file_exists($destinationPath)) {
							mkdir($destinationPath);
						}

						$upload_pdf->move($destinationPath, $filename);
					}
					Ebook::editModule($i, $r, $filename);
					return Redirect::to('admin/ebook/thumbnails/'.$i)->with('status','Ebook Saved !');
				}
			}
			elseif($sub == 'thumbnails')
			{
				$rules = array(
					'upload_images' => 'mimes:jpeg,jpg,png|required|max:5000' // max 5000kb
				);
				$validator = Validator::make($r->all(), $rules);
				if($validator->fails())
				{
					return Redirect::to('admin/ebook/thumbnails/'.$i)->withErrors($validator->errors());
				}
				else
				{
					$upload_images	= Input::file('upload_images');
					$filename 		= time().'.'.$upload_images->getClientOriginalExtension();
					//$destinationPath = 'module/thumbnails/';
					$destinationPath = 'public/module/thumbnails/temp';
					if (!file_exists($destinationPath)) {
						mkdir($destinationPath);
					}

					$target_file		= $destinationPath.'/'.$filename;
					move_uploaded_file($_FILES["upload_images"]["tmp_name"], $target_file);
					if(Ebook::UploadThumbnailsImages($i, $filename))
					{
						//return Redirect::to('admin/ebook/view/'.$i)->with('message','Content Added');
						return Redirect::to('admin/ebook/thumbnails-crop/'.$i)->with('message','Content Added');
					}
				}
			}
			elseif($sub == 'thumbnails-crop')
			{
				$dataurlimage = Input::get('dataurlimage');
				if($dataurlimage != '')
				{
					//try
					//{
						if(strlen($dataurlimage) > 128) {
							list($ext, $data)   = explode(';', $dataurlimage);
							list(, $data)       = explode(',', $data);
							$data = base64_decode($data);

							$filename = time().'.jpg';
							$destinationPath 	= 'public/module/thumbnails/';
							unlink($destinationPath.'temp/'.Ebook::getDataEbook($i)->img);
							if(!File::isDirectory($destinationPath))
							{
								File::makeDirectory($destinationPath, 0775, true, true);
							}
							$target_file		= $destinationPath.'/'.$filename;

							file_put_contents($target_file, $data);

							Images::resize(252, $target_file, $target_file);

							Ebook::UploadThumbnailsImages($i, $filename);
						}
					//}
					//catch (\Exception $e) {
						//$msg = $e;
					//}
					return Redirect::to('admin/ebook/view/'.$i)->with('status','Ebook Thumbnail Updated !');
				}
				else
				{
					return Redirect::to('admin/ebook/view/'.$i)->with('error','There an occured a problem during croping your image !');
				}
			}
		}
	}

	function albumAction($sub = '', $i = '', Request $r)
	{
		if(Auth::user()->isAdmin() || Auth::user()->isEditor())
		{
			if($sub == 'new')
			{
				$rules = array(
					'title_album'	=> 'required|string|max:255',
					'desc_album' 	=> 'required|string|max:255'
				);
				$validator = Validator::make($r->all(), $rules);
				if($validator->fails())
				{
					return Redirect::to('admin/albums/new')->withErrors($validator->errors());
				}
				else
				{
					return Redirect::to('admin/albums/upload/'.AlbumRack::createAlbum($r))->with('message','Album Created');
					// return Redirect::to('admin/albums/upload/')->with('message','Album Created');
				}
			}
			elseif($sub == 'edit')
			{
				$rules = array(
					'title_album'	=> 'required|string|max:255',
					'desc_album' 	=> 'required|string|max:255'
				);
				$validator = Validator::make($r->all(), $rules);
				if($validator->fails())
				{
					return Redirect::back()->withErrors($validator->errors());
				}
				else
				{
					AlbumRack::editAlbum($r, $i);
					return Redirect::to('admin/albums/view/'.$i)->with('message','Album Edited');
				}
			}
			elseif($sub == 'upload')
			{

				$files = Input::file('imageuploader');
				$file_count = count($files);
				$uploadcount = 0;
				foreach($files as $file)
				{
					$rules = array('file' => 'mimes:jpeg,jpg,png,gif|required');
					$validator = Validator::make(array('file'=> $file), $rules);
					if($validator->passes()){

						$id			= Input::get('id');

						$filename 	= md5(time().$file->getRealPath()).'.'.$file->getClientOriginalExtension();
						$AlbumRack	= AlbumRack::getDataAlbum($id);

						list($width, $height) = getimagesize($file) ;
						$tn = imagecreatetruecolor($width, $height) ;
						if($file->getClientOriginalExtension() == 'jpg' || $file->getClientOriginalExtension() == 'jpeg' || $file->getClientOriginalExtension() == 'JPG' || $file->getClientOriginalExtension() == 'JPEG')
						{
							$image = imagecreatefromjpeg($file);
						}
						elseif($file->getClientOriginalExtension() == 'png' || $file->getClientOriginalExtension() == 'PNG')
						{
							$image = imagecreatefrompng($file);
						}
						elseif($file->getClientOriginalExtension() == 'gif' || $file->getClientOriginalExtension() == 'GIF')
						{
							$image = imagecreatefromgif($file);
						}
						imagecopyresampled($tn, $image, 0, 0, 0, 0, $width, $height, $width, $height) ;

						$destinationPath = 'public/album/'.$AlbumRack->id_album;
						if(!File::isDirectory($destinationPath))
						{
							File::makeDirectory($destinationPath, 0775, true, true);
						}
						$target_file		= $destinationPath.'/'.$filename;
						//move_uploaded_file($file, $target_file);

						imagejpeg($tn, $target_file, 50) ;

						//try
						//{
							//File::makeDirectory($destinationPath . '/thumbnails/small', 0775, true, true);
							//Images::resize(500, $destinationPath . '/thumbnails/small/' . $filename, $target_file);
							// $img = Image::make($file->getRealPath());
							// if($img->save($destinationPath.'/'.$filename))
							// {
							AlbumRack::createImage($id, $filename);
							// }
						//}
						//catch (\Exception $e) {
							//$msg = $e;
						//}

					}
				}
				echo '{}';
			}
			elseif($sub == 'crop-image-thumbnails') {

				$dataurlimage = Input::get('dataurlimage');
				if ($dataurlimage != '') {
					$dataRack = AlbumRack::getDataImage($i);
					//try {
						if (strlen($dataurlimage) > 128) {
							list($ext, $data) = explode(';', $dataurlimage);
							list(, $data) = explode(',', $data);
							$data = base64_decode($data);
							if (!file_exists('public/album/' . $dataRack->id_album . '/thumbnails/')) {
								mkdir('public/album/' . $dataRack->id_album . '/thumbnails/');
							}
							$oldfile	= 'public/album/'.$dataRack->id_album.'/thumbnails/'.$dataRack->alias;
							if(file_exists($oldfile) && $dataRack->alias != '')
								unlink($oldfile);
							$filename		= time().'.jpg';
							$target_file 	= 'public/album/' . $dataRack->id_album . '/thumbnails/' . $filename;

							file_put_contents($target_file, $data);
							AlbumRack::uploadThumbnailsImages($i, $filename);
						}
					//} catch (\Exception $e) {
						//$msg = $e;
					//}
					return Redirect::to('admin/albums/crop-image-thumbnails/' . $i)->with('status', 'Image Cropped !');
				}
			}
			elseif($sub == 'crop-album-thumbnails')
			{

				$dataurlimage = Input::get('dataurlimage');
				if($dataurlimage != '')
				{
					$dataRack	= AlbumRack::getDataImage($i);
					//try
					//{
						if(strlen($dataurlimage) > 128) {
							list($ext, $data)   = explode(';', $dataurlimage);
							list(, $data)       = explode(',', $data);
							$data = base64_decode($data);
							if(!file_exists('public/album/'.$dataRack->id_album.'/thumbnails/'))
							{
								mkdir('public/album/'.$dataRack->id_album.'/thumbnails/');
							}
							$oldfile	= 'public/album/'.$dataRack->id_album.'/thumbnails/'.AlbumRack::getDataAlbum($dataRack->id_album)->thumbnails;
							if(file_exists($oldfile) && $dataRack->thumbnails != '')
								unlink($oldfile);
							$filename		= time().'.jpg';
							$target_file 	= 'public/album/'.$dataRack->id_album.'/thumbnails/'.$filename;

							file_put_contents($target_file, $data);
							AlbumRack::uploadThumbnailsAlbum(AlbumRack::getDataImage($i)->id_album, $filename);
						}
					//}
					//catch (\Exception $e) {
						//$msg = $e;
					//}
					return Redirect::to('admin/albums/crop-album-thumbnails/'.$i)->with('status','Image Cropped !');
				}
				else
				{
					return Redirect::to('admin/albums/crop-album-thumbnails/'.$i)->with('error','Error Uploading Images !');
				}

			}
			elseif($sub == 'thumbnails')
			{

			}
		}
	}

	function adsAction($sub = '', $i = '', Request $r)
	{
		if (Auth::user()->isAdmin() || Auth::user()->isEditor())
		{
			if ($sub == 'new')
			{
				$rules = array(
					'title_ads'	=> 'required|string|max:50',
					'image' 	=> 'mimes:jpeg,jpg,png,gif|required|max:10000',
					'url' 		=> 'required',
					'size' 		=> 'required',
				);
				$validator = Validator::make($r->all(), $rules);
				if($validator->fails())
				{
					return Redirect::to('admin/ads/new')->withErrors($validator->errors())->withInput();
				}
				else
				{
					$file = Input::file('image');
					$filename = time().'.'.$file->getClientOriginalExtension();

					$destinationPath = 'public/ads-image';

					if (!file_exists($destinationPath))
					{
						mkdir($destinationPath);
					}

					list($width, $height) 	= getimagesize($file);
					if(($width == '850' && $height == '454') || ($width == '402' && $height == '281'))
					{
						$target_file		= $destinationPath.'/'.$filename;
						move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

						AdsContainer::createAds($r,$filename);
						return Redirect::to('admin/ads/')->with('status','Ads added !');
					}
					else
					{
						$tmp_filename	= time().'.'.$file->getClientOriginalExtension();
						session::set('crop_filename', $tmp_filename);

						$target_file = $destinationPath.'/temp/'.$tmp_filename;

						move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

						if(Input::get('size') == '850454')
						{
							Images::resize(850, $target_file, $target_file);
						}
						else
						{
							Images::resize(402, $target_file, $target_file);
						}
						return Redirect::to('admin/ads/edit/'.AdsContainer::createAds($r,$filename))->with('message_error','Your selected image size doesn\'t match with our ads size !');
					}

				}
			}
			elseif ($sub == 'edit')
			{
				$rules = array(
					'title_ads'	=> 'required|string|max:50',
					//'image' 	=> 'mimes:jpeg,jpg,png,gif|required|max:5000',
					'url' 		=> 'required',
					'size' 		=> 'required',
				);
				$validator = Validator::make($r->all(), $rules);
				if($validator->fails())
				{
					return Redirect::to('admin/ads/edit'.$i)->withErrors($validator->errors());
				}
				else
				{

					if($r->hasFile('image'))
					{

						$file = Input::file('image');
						$filename = AdsContainer::getDataAds($i)->image;

						$destinationPath = 'public/ads-image';
						$target_file			= $destinationPath.'/'.$filename;

						list($width, $height) 	= getimagesize($_FILES["image"]["tmp_name"]);
						if(($width == '850' && $height == '454') || ($width == '402' && $height == '281'))
						{
							move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
							AdsContainer::editAds($i, $r);
							return Redirect::to('admin/ads/edit/'.$i)->with('message','Ads Edited');
						}
						else
						{
							AdsContainer::editAds($i, $r);
							$tmp_filename	= time().'.'.$file->getClientOriginalExtension();
							session::set('crop_filename', $tmp_filename);

							$target_file = $destinationPath.'/temp/'.$tmp_filename;

							move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

							if(Input::get('size') == '850454')
							{
								Images::resize(850, $target_file, $target_file);
							}
							else
							{
								Images::resize(402, $target_file, $target_file);
							}
							return Redirect::to('admin/ads/edit/'.$i)->with('message_error','Your selected image size doesn\'t match with our ads size !');
						}

					}
					else
					{
						AdsContainer::editAds($i, $r);
						return Redirect::to('admin/ads/edit/'.$i)->with('message','Ads Edited');
					}

				}
			}
			elseif ($sub == 'crop')
			{

				$dataurlimage = Input::get('dataurlimage');
				if($dataurlimage != '')
				{
					$destinationPath 	= 'public/ads-image';
					$filename			= Session::get('crop_filename');
					try
					{
						if(strlen($dataurlimage) > 128) {
							list($ext, $data)   = explode(';', $dataurlimage);
							list(, $data)       = explode(',', $data);
							$data = base64_decode($data);
							$target_file		= $destinationPath.'/'.$filename;
							file_put_contents($target_file, $data);
							AdsContainer::editAdsFilename($i, $filename);
							unlink($destinationPath.'/temp/'.$filename);
						}
					}
					catch (\Exception $e) {
					$msg = $e;
					}
					Session::forget('crop_filename');
					return Redirect::to('admin/ads/edit/'.$i)->with('status','Ads Edited !');
				}
			}
		}
	}

	function setting($sub = '', $i = '')
	{
		if (Auth::user()->isAdmin())
		{
			if ($sub == '')
			{
				AdminConfig::setBreadcumb('setting-home');
				$data = array(
					'page' => 'setting',
					'sub' => 'home',
					'data' => array()
				);
				return View::make('admin.template', $data);
			}
			elseif ($sub == 'category')
			{
				if($i == 'new')
				{
					AdminConfig::setBreadcumb('setting-category-new');
					$data	= array(
						'page'			=> 'setting',
						'sub'			=> 'create-category',
						'data'			=> 'existing',
						'data_detail'	=> '',
					);
					return View::make('admin.template', $data);
				}
				else
				{
					if($i == '')
					{
						AdminConfig::setBreadcumb('setting-category-home');
						$data	= array(
							'page'		=> 'setting',
							'sub'		=> 'category',
							'data'		=> PostCategory::getCategory(),
							'category'	=> '',
						);
						return View::make('admin.template', $data);
					}
					else
					{
						$data	= PostCategory::getCategory($i);
						if(count($data)>0)
						{
							AdminConfig::setBreadcumb('setting-category-edit');
							$data	= array(
								'page'		=> 'setting',
								'sub'		=> 'edit-category',
								'data'		=> PostCategory::getCategory($i),
								'category_id'=> $i,
							);
							return View::make('admin.template', $data);
						}
					}
				}
			}
			elseif ($sub == 'newsletter')
			{
				AdminConfig::setBreadcumb('setting-newsletter');
				$data	= array(
					'page'		=> 'setting',
					'sub'		=> 'newsletter',
					'data'		=> SettingBlog::getNewsletter(),
					'category'	=> '',
				);
				return View::make('admin.template', $data);
			}
			elseif ($sub == 'widget')
			{
				AdminConfig::setBreadcumb('setting-widget');
				$data	= array(
					'page'		=> 'setting',
					'sub'		=> 'widget',
					'data'		=> SettingBlog::getNewsletter(),
					'category'	=> '',
				);
				return View::make('admin.template', $data);
			}
			elseif ($sub == 'about')
			{
				if($i == 'id')
				{
					AdminConfig::setBreadcumb('setting-about-edit');
					$data = array(
						'page' 		=> 'setting',
						'sub' 		=> 'about-edit',
						'language' 	=> $i,
						'data' 		=> SettingBlog::getAbout('id'),
					);
					return View::make('admin.template', $data);
				}
				elseif($i == 'privacy')
				{
					AdminConfig::setBreadcumb('setting-about-privacy');
					$data = array(
						'page' 		=> 'setting',
						'sub' 		=> 'privacy',
						'data' 		=> SettingBlog::getPrivacy(),
					);
					return View::make('admin.template', $data);
				}
				elseif($i == 'terms-condition')
				{
					AdminConfig::setBreadcumb('setting-about-term');
					$data = array(
						'page' 		=> 'setting',
						'sub' 		=> 'terms-condition',
						'data' 		=> SettingBlog::getTermsCondition(),
					);
					return View::make('admin.template', $data);
				}
				else
				{
					AdminConfig::setBreadcumb('setting-about-home');
					$data = array(
						'page' 	=> 'setting',
						'sub' 	=> 'about',
						'data' 	=> array(),
					);
					return View::make('admin.template', $data);
				}
			}
			elseif ($sub == 'theme')
			{
				AdminConfig::setBreadcumb('setting-theme');
				$data = array(
					'page' 	=> 'setting',
					'sub' 	=> 'theme',
					'data' 	=> SettingBlog::getTheme(),
				);
				return View::make('admin.template', $data);
			}
		}
	}

	function settingAction($sub = '', $i = '', Request $r)
	{
		if($sub == 'category')
		{
			$rules = array(
				'category'		=> 'required|max:50',
			);
			$validator	= Validator::make($r->all(), $rules);
			if($validator->fails())
			{
				return Redirect::back()->withErrors($validator->errors())->withInput();
			}
			else
			{
				if($i == 'new')
				{
					PostCategory::CreateCategory($r);
					return Redirect::to('admin/setting/category')->with('message','Content Added');
				}
				else
				{
					PostCategory::EditCategory($i, $r);
					return Redirect::to('admin/setting/category')->with('message','Content Edited');
				}
			}
		}
		elseif($sub == 'newsletter')
		{
			if(Input::hasFile('upload_images'))
			{
				if (Input::file('upload_images')->isValid())
				{
					$destinationPath = 'images/newsletter';
					$target_file	= $destinationPath.'/bg-newsletter.jpg';
					move_uploaded_file($_FILES["upload_images"]["tmp_name"], $target_file);
				}
			}

			SettingBlog::updateNewsletter($r);
			return Redirect::back()->with('message', 'Newsletter Updated !');

		}
		elseif($sub == 'newsletter-body')
		{
			SettingBlog::updateNewsletterBody($r);
			return Redirect::back()->with('message', 'Newsletter Updated !');

		}
		elseif($sub == 'theme')
		{
			$filename	= '';
			$upload_images	= Input::file('upload_images');
			if(Input::hasFile('upload_images'))
			{
				if ($upload_images->isValid())
				{
					$destinationPath = 'images/background';
					$filename		= md5(time()).'.'.$upload_images->getClientOriginalExtension();
					$target_file	= $destinationPath.'/'.$filename;
					move_uploaded_file($_FILES["upload_images"]["tmp_name"], $target_file);
				}
			}
			SettingBlog::updateThemes($r, $filename);
			return Redirect::back()->with('message', 'Configuration Updated !');
		}
		elseif($sub == 'widget')
		{
			SettingBlog::updateWidget($r);
			return Redirect::back()->with('message', 'Configuration Updated !');
		}
		else
		{

		}
	}

	function aboutAction($sub = '', $i = '', Request $r)
	{
		if($sub == 'privacy')
		{
			$rules = array(
				'textcontent' => 'required|string',
			);
			$validator = Validator::make($r->all(), $rules);
			if($validator->fails())
			{
				return Redirect::back()->withErrors($validator->errors())->withInput();
			}
			else
			{
				SettingBlog::privacyAddText($r);
				return Redirect::back()->with('message','Your Content Updated !');
			}
		}
		elseif($sub == 'terms-condition')
		{
			$rules = array(
				'textcontent' => 'required|string',
			);
			$validator = Validator::make($r->all(), $rules);
			if($validator->fails())
			{
				return Redirect::back()->withErrors($validator->errors())->withInput();
			}
			else
			{
				SettingBlog::termsAddText($r);
				return Redirect::back()->with('message','Your Content Updated !');
			}
		}
		else
		{
			if($i == 'addtext')
			{
				$rules = array(
					'textcontent' => 'required|string',
				);
				$validator = Validator::make($r->all(), $rules);
				if($validator->fails())
				{
					return Redirect::back()->withErrors($validator->errors())->withInput();
				}
				else
				{
					SettingBlog::aboutAddText($r,$sub);
					return Redirect::back()->with('message','Your Content Updated !');
				}
			}
		}
	}

	function contactAction(Request $r)
	{
		$rules = array(
			'date_from' => 'date|string',
			'date_to' 	=> 'date|string',
		);
		$validator = Validator::make($r->all(), $rules);
		if($validator->fails())
		{
			return Redirect::back()->withErrors($validator->errors())->withInput();
		}
		else
		{
			session::set('export',array('from'=>Input::get('date_from'), 'to'=>Input::get('date_to')));
			return Redirect::to('admin/export/excel/contact');
		}
	}
	
	function notification()
	{
		NotificationController::setSeenNotification('comments');
		$data	= array(
			'page'	=> 'notification',
			'sub'	=> 'home',
			'data' 	=> NotificationController::getNotificationAll(),
		);
		return View::make('admin.template', $data);
	}

}
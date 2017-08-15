<?php

namespace App\Http\Controllers;

use View;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Neodigital\Blog\Ebook;
use Neodigital\Blog\ContactList;
use Neodigital\Blog\Statistic;
use Neodigital\Blog\Newsletter;
use Neodigital\Blog\PostEditor;


class ExportController extends Controller
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

    }

    public function exportExcel($content)
    {
        if($content == 'newsletter')
        {
            $data   = array(
                'data'      => Newsletter::getParticipant('',''),
                'filename'  => 'Participant_Newsletter_'.date('d-M-Y').'_maxiblogger.xls',
                'content'   => $content,
            );
            return View::make('export.excel', $data);
        }
        elseif($content == 'contact')
        {
            $export_rangedate   = Session::get('export');
            $data   = array(
                'data'      => ContactList::getContactByRangeDate($export_rangedate),
                'filename'  => 'Contact_'.date('d-M-Y').'_from_'.$export_rangedate['from'].'_to_'.$export_rangedate['to'].'_maxiblogger.xls',
                'content'   => $content,
            );
            return View::make('export.excel', $data);
        }
        elseif($content == 'summary-visitor')
        {
            $data   = array(
                'data'      => Statistic::getExportVisitorSummary(),
                'filename'  => 'Visitor_'.date('d-M-Y').'.xls',
                'content'   => $content,
            );
            return View::make('export.excel', $data);
        }
    }

    public function createTable($data)
    {

    }

    public function exportExcelAction(Request $r)
    {
		$content    = Input::get('content');
        if($content == 'newsletter')
        {
            $data   = array(
                'data'      => Newsletter::getParticipantByRangeDate(Input::get('from'),Input::get('to')),
                'filename'  => 'Participant_Newsletter_'.date('d-M-Y').'_maxiblogger.xls',
                'content'   => $content,
            );
            return View::make('export.excel', $data);
        }
        elseif($content == 'ebook-download')
        {
            $data   = array(
                'data'      => Ebook::getDataEbookDownloadByRangeDate(Input::get('id_ebook'),Input::get('from'),Input::get('to')),
                'filename'  => 'Ebook_'.Input::get('id_ebook').'_'.date('d-M-Y').'_maxiblogger.xls',
                'content'   => 'ebook-download',
            );
            return View::make('export.excel', $data);
        }
        elseif($content == 'summary-visitor')
        {
            $data   = array(
                'data'      => Statistic::getExportVisitorByRangeDate(Input::get('from'),Input::get('to')),
                'filename'  => 'Visitor_'.date('d-M-Y').'.xls',
                'content'   => $content,
            );
            return View::make('export.excel', $data);
        }
        elseif($content == 'viewers')
        {
			$id_postlanguage	= Input::get('id_postlanguage');
            $data   = array(
				'title'		=> PostEditor::getDataPost($id_postlanguage)->title,
                'data'      => Statistic::getExportViewerByRangeDate($id_postlanguage,Input::get('from'),Input::get('to')),
                'filename'  => 'Viewers_'.date('d-M-Y').'.xls',
                'content'   => $content,
            );
            return View::make('export.excel', $data);
        }
        elseif($content == 'share')
        {
			$id_postlanguage	= Input::get('id_postlanguage');
            $data   = array(
				'title'		=> PostEditor::getDataPost($id_postlanguage)->title,
                'data'      => Statistic::getExportSharedByRangeDate($id_postlanguage,Input::get('from'),Input::get('to')),
                'filename'  => 'Shared_'.date('d-M-Y').'.xls',
                'content'   => $content,
            );
            return View::make('export.excel', $data);
        }
    }

	
}

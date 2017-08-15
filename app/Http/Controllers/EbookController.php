<?php

namespace App\Http\Controllers;

use View;
use Auth;
use Validator;
use Image;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Neodigital\Blog\AlbumRack;
use Neodigital\Blog\Language;
use Neodigital\Blog\Website;
use Neodigital\Blog\Ebook;
use Neodigital\Blog\Pdf;

class EbookController extends Controller
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

        Language::index();
        Website::setPage('ebook');
        Website::update_visitor('ebook');

        $data   = array(
            'category'      => 'Ebook',
            'page'          => 'list',
        );

        return View::make('ebook', $data);

    }

    public function detail($i = '')
    {

        Language::index();
        Website::setPage('ebook');

        $data   = array(
            'category'      => 'Ebook',
            'page'          => 'detail',
            'data'          => Ebook::getDataEbook($i),
        );

        return View::make('ebook', $data);
    }

    public function form()
    {
        return View::make('section.ebook.form');
    }

    public function insertData(Request $r)
    {

        $rules = array(
            'name'              => 'required|max:250',
            'telephone'         => 'required|numeric',
            'emaildownload'     => 'required|email',
            'nama_perusahaan'   => 'required|max:100',
            'jabatan'           => 'required|max:100',
            'jenis_usaha'       => 'required|max:255',
            'jumlah_karyawan'   => 'required|max:100',
            'alamat_perusahaan' => 'required|max:100',
        );
        $validator = Validator::make($r->all(), $rules);
        if($validator->fails() || substr(Input::get('telephone'), 0, 2) != '08')
        {
            echo 'failed';
        }
        else
        {
            Ebook::InsertDataDownloader($r);
            return Pdf::ebook(Ebook::getDataEbook(Input::get('id_ebook'))->filename);
        }

    }

    public function getError(Request $r)
    {
        $rules = array(
            'name'              => 'required|max:250',
            'telephone'         => 'required|numeric',
            'emaildownload'     => 'required|email',
            'nama_perusahaan'   => 'required|max:100',
            'jabatan'           => 'required|max:100',
            'jenis_usaha'       => 'required|max:255',
            'jumlah_karyawan'   => 'required|max:100',
            'alamat_perusahaan' => 'required|max:100',
        );
        $validator = Validator::make($r->all(), $rules);
        if($validator->fails())
        {
            echo $validator->errors();
        }
    }



}

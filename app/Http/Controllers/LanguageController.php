<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redirect;
use Neodigital\Blog\Language;

class LanguageController extends BaseController
{

	public static function setLang($c)
	{
		Language::setLang($c);
		return redirect::back();
	}
	
}
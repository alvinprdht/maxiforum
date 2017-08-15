<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {
	
	Route::get('/', [
		"as" => "home",
		"uses" => "HomeController@index"
	]);

	Route::get('/home/result-poll', [
		"as" => "home.poll",
		"uses" => "HomeController@resultPoll"
	]);

	Route::get('/category/{c?}', [
		"as" => "category",
		"uses" => "CategoryController@index"
	]);

	Route::get('/video/', [
		"as" => "video",
		"uses" => "VideoController@index"
	]);

	Route::get('/news/', [
		"as" => "news",
		"uses" => "NewsController@index"
	]);

	Route::get('/photo/', [
		"as" => "photo",
		"uses" => "PhotoController@index"
	]);

	Route::get('/photo/{i?}', [
		"as" => "photo",
		"uses" => "PhotoController@detail"
	]);

	Route::get('/photo/{i?}/{j?}', [
		"as" => "photo",
		"uses" => "PhotoController@photo"
	]);

	Route::get('/ebook/', [
		"as" => "ebook",
		"uses" => "EbookController@index"
	]);

	Route::get('/ebook/form', [
		"as" => "ebook",
		"uses" => "EbookController@form"
	]);

	Route::post('/ebook/insertdata', [
		"as" => "insertdata",
		"uses" => "EbookController@insertData"
	]);

	Route::post('/ebook/getError', [
		"as" => "getError",
		"uses" => "EbookController@getError"
	]);

	Route::get('/ebook/{i?}', [
		"as" => "ebook",
		"uses" => "EbookController@detail"
	]);

	Route::get('/about/', [
		"as" => "about",
		"uses" => "AboutController@index"
	]);

	Route::get('/privacy-policy/', [
		"as" => "privacyPolicy",
		"uses" => "AboutController@privacyPolicy"
	]);

	Route::get('/term-and-condition/', [
		"as" => "termCondition",
		"uses" => "AboutController@termCondition"
	]);

	Route::get('/article/{c?}/{t?}', [
		"as" => "category",
		"uses" => "ArticleController@index"
	]);

	Route::get('/search/{s?}', [
		"as" => "search",
		"uses" => "SearchController@index"
	]);

	Route::get('/tags/{s?}', [
		"as" => "search",
		"uses" => "SearchController@tags"
	]);

	Route::get('/publish/{s?}', [
		"as" => "search",
		"uses" => "SearchController@publish"
	]);

	Route::get('/contact-us', [
		"as" => "contact",
		"uses" => "ContactController@index"
	]);

	Route::post('/search', [
		"as" => "postsearch",
		"uses" => "SearchController@search"
	]);

	Route::post('/contact-us', [
		"as" => "contact",
		"uses" => "ContactController@send"
	]);


	Route::post('/article/comments/', [
		"as" => "category",
		"uses" => "ArticleController@comments"
	]);

	Route::post('/article/share/', [
		"as" => "share",
		"uses" => "ArticleController@share"
	]);

	Route::get('/lang/{c?}', [
		"as" => "lang",
		"uses" => "LanguageController@setLang"
	]);

	Route::get('/verify/{c?}', [
		"as" => "lang",
		"uses" => "VerifyController@index"
	]);

	Route::post('/verify/updatepassword', [
		"as" => "lang",
		"uses" => "VerifyController@updatepassword"
	]);

	Route::post('/home/submitpoll', [
		"as" => "submitpoll",
		"uses" => "HomeController@submitPoll"
	]);

	Route::get('/home/requestnewsletter', [
		"as" => "requestNewsletter",
		"uses" => "HomeController@requestNewsletter"
	]);

	Route::post('/home/requestnewsletter', [
		"as" => "requestNewsletter",
		"uses" => "HomeController@requestNewsletter"
	]);
});

Route::get('/newsletter/thanksforsubscribe', [
	"as" => "newsletter.thanksubscribe",
	"uses" => "NewsletterController@thanksubscribe"
]);

Route::get('/activate/{md_userid?}', [
	"as" => "admin.activate",
	"uses" => "AdminController@activate",
]);
Route::post('/activate/{md_userid?}', [
	"as" => "admin.activate",
	"uses" => "AdminController@activateAction",
]);

Route::post('/resetpass', [
	"as" => "admin.resetpass",
	"uses" => "AdminController@resetpassLoginAction"
]);
Route::get('/resetpass/{md_userid?}', [
	"as" => "admin.resetpass",
	"uses" => "AdminController@resetpass",
]);
Route::post('/resetpass/{md_userid?}', [
	"as" => "admin.resetpass",
	"uses" => "AdminController@resetpassAction",
]);

Route::get('/admin', [
	"as" => "admin.home",
	"uses" => "AdminController@index",
	"middleware" => ["auth"]
]);

Route::get('/admin/notification', [
	"as" => "admin.home",
	"uses" => "AdminController@notification",
	"middleware" => ["auth"]
]);

Route::get('/admin/statistic/{sub?}/{i?}', [
	"as" => "admin.statistic",
	"uses" => "AdminController@statistic",
	"middleware" => ["auth"]
]);

Route::get('/admin/profile/{sub?}', [
	"as" => "admin.myprofile",
	"uses" => "AdminController@profile",
	"middleware" => ["auth"]
]);

Route::get('/admin/post/{sub?}/{i?}', [
	"as" => "admin.post",
	"uses" => "AdminController@post",
	"middleware" => ["auth"]
]);

Route::get('/admin/user/{sub?}/{i?}', [
	"as" => "admin.user",
	"uses" => "AdminController@user",
	"middleware" => ["auth", "admin"]
]);

Route::get('/admin/polling/{sub?}/{i?}', [
	"as" => "admin.polling",
	"uses" => "AdminController@polling",
	"middleware" => ["auth", "admin"]
]);

Route::get('/admin/ebook/{sub?}/{i?}', [
	"as" => "admin.ebook",
	"uses" => "AdminController@ebook",
	"middleware" => ["auth", "admin"]
]);

Route::get('/admin/setting/{sub?}/{i?}', [
	"as" => "admin.setting",
	"uses" => "AdminController@setting",
	"middleware" => ["auth", "admin"]
]);

Route::get('/admin/album/{sub?}/{i?}', [
	"as" => "admin.albums",
	"uses" => "AdminController@albums",
	"middleware" => ["auth", "admin"]
]);

Route::get('/admin/albums/{sub?}/{i?}', [
	"as" => "admin.albums",
	"uses" => "AdminController@albums",
	"middleware" => ["auth", "admin"]
]);

Route::get('/admin/ads/{sub?}/{i?}', [
	"as" => "admin.ads",
	"uses" => "AdminController@ads",
	"middleware" => ["auth", "admin"]
]);

Route::get('/admin/export/excel/{content?}', [
	"as" => "export",
	"uses" => "ExportController@exportExcel",
	"middleware" => ["auth"]
]);
Route::post('/admin/export/excel', [
	"as" => "export",
	"uses" => "ExportController@exportExcelAction",
	"middleware" => ["auth"]
]);

Route::get('/admin/contact/{sub?}/{i?}', [
	"as" => "admin.contact",
	"uses" => "AdminController@contact",
	"middleware" => ["auth"]
]);

Route::post('/admin/profile/{sub?}', [
	"as" => "admin.myprofile",
	"uses" => "AdminController@profileAction",
	"middleware" => ["auth"]
]);

Route::post('/admin/post/{sub?}/{i?}/{task?}', [
	"as" => "admin.post",
	"uses" => "AdminController@postAction",
	"middleware" => ["auth"]
]);

Route::post('/admin/user/{sub?}', [
	"as" => "admin.user",
	"uses" => "AdminController@userAction",
	"middleware" => ["auth", "admin"]
]);

Route::post('/admin/polling/{sub?}/{i?}', [
	"as" => "admin.polling",
	"uses" => "AdminController@pollingAction",
	"middleware" => ["auth", "admin"]
]);

Route::post('/admin/ebook/{sub?}/{i?}', [
	"as" => "admin.ebook",
	"uses" => "AdminController@ebookAction",
	"middleware" => ["auth", "admin"]
]);

Route::post('/admin/albums/{sub?}/{i?}', [
	"as" => "admin.albums",
	"uses" => "AdminController@albumAction",
	"middleware" => ["auth", "admin"]
]);

Route::post('/admin/ads/{sub?}/{i?}', [
	"as" => "admin.ads",
	"uses" => "AdminController@adsAction",
	"middleware" => ["auth", "admin"]
]);

Route::post('/admin/setting/{sub?}/{i?}', [
	"as" => "admin.setting",
	"uses" => "AdminController@settingAction",
	"middleware" => ["auth", "admin"]
]);

Route::post('/admin/setting/about/{sub?}/{i?}', [
	"as" => "admin.setting",
	"uses" => "AdminController@aboutAction",
	"middleware" => ["auth", "admin"]
]);

Route::post('/admin/contact/export', [
	"as" => "admin.contactexport",
	"uses" => "AdminController@contactAction",
	"middleware" => ["auth", "admin"]
]);

Route::get('/ajax/admin/postdetaildraft/{i?}', [
	"as" => "ajax.postdetaildraft",
	"uses" => "AjaxController@postDetailDraft",
]);

Route::get('/ajax/admin/post/get/{page?}/{c?}/{p?}/{t?}/{o?}/{b?}', [
	"as" => "ajax.postSearch",
	"uses" => "AjaxController@postSearch",
]);
Route::get('/ajax/admin/post/getcount/{page?}/{c?}/{p?}/{t?}/{o?}/{b?}', [
	"as" => "ajax.postSearch",
	"uses" => "AjaxController@postSearchCount",
]);

Route::get('/ajax/admin/draft/get/{page?}/{s?}/{l?}/{t?}/{o?}/{b?}', [
	"as" => "ajax.draftSearch",
	"uses" => "AjaxController@draftSearch",
]);

Route::get('/ajax/admin/draft/getcount/{page?}/{s?}/{l?}/{t?}/{o?}/{b?}', [
	"as" => "ajax.draftSearchCount",
	"uses" => "AjaxController@draftSearchCount",
]);

Route::get('/ajax/admin/review/get/{page?}/{c?}/{p?}/{s?}/{t?}/{o?}/{b?}', [
	"as" => "ajax.reviewSearch",
	"uses" => "AjaxController@reviewSearch",
]);

Route::get('/ajax/admin/review/getcount/{page?}/{c?}/{p?}/{s?}/{t?}/{o?}/{b?}', [
	"as" => "ajax.reviewSearchCount",
	"uses" => "AjaxController@reviewSearchCount",
]);

Route::get('/ajax/admin/ads/get/{page?}/{s?}/{t?}/{o?}/{b?}', [
	"as" => "ajax.reviewSearch",
	"uses" => "AjaxController@adsSearch",
]);

Route::get('/ajax/admin/ads/getcount/{page?}/{s?}/{t?}/{o?}/{b?}', [
	"as" => "ajax.reviewSearchCount",
	"uses" => "AjaxController@adsSearchCount",
]);

Route::get('/ajax/admin/polling/get/{page?}/{t?}/{o?}/{b?}', [
	"as" => "ajax.reviewSearch",
	"uses" => "AjaxController@pollSearch",
]);

Route::get('/ajax/admin/polling/getcount/{page?}/{t?}/{o?}/{b?}', [
	"as" => "ajax.reviewSearchCount",
	"uses" => "AjaxController@pollSearchCount",
]);

Route::get('/ajax/admin/ebook/get/{page?}/{t?}/{o?}/{b?}', [
	"as" => "ajax.reviewSearch",
	"uses" => "AjaxController@ebookSearch",
]);

Route::get('/ajax/admin/ebook/getcount/{page?}/{t?}/{o?}/{b?}', [
	"as" => "ajax.reviewSearchCount",
	"uses" => "AjaxController@ebookSearchCount",
]);

Route::post('/login', [
	"as" => "admin.user",
	"uses" => "AdminController@userAction"
]);
Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/505', 'HomeController@error');

Route::get('/505', 'HomeController@error');
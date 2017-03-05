<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
use App\Book;

Route::get('/', function () {
	if(Auth::check()){
		return redirect('home');
	}else{
		return view('welcome');
	}    
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/category/create','MainController@create');
Route::get('/category/index','MainController@index');
Route::get('/category/edit/{id}','MainController@edit');
Route::post('/category/store','MainController@store');
Route::post('/category/update/{id}','MainController@update');
Route::any('/category/destroy/{id}', 'MainController@destroy');

Route::get('/class/create','ClassController@create');
Route::get('/class/create/{id}','ClassController@createId');
Route::get('/class/index','ClassController@index');
Route::get('/class/index/{id}','ClassController@indexSort');
Route::get('/class/edit/{id}','ClassController@edit');
Route::post('/class/store','ClassController@store');
Route::post('/class/update/{id}','ClassController@update');
Route::any('/class/destroy/{id}', 'ClassController@destroy');

Route::get('/book/create', 'BookController@create');
Route::get('/book/create/{id}', 'BookController@createId');
Route::post('/book/store', 'BookController@store');
Route::get('/book/index','BookController@index');
Route::get('/book/index/{id}','BookController@indexSort');
Route::post('/book/update/{id}', 'BookController@update');
Route::get('/book/edit/{id}', 'BookController@edit');
Route::any('/book/destroy/{id}', 'BookController@destroy');

Route::get('/content/create', 'ContentController@create');
Route::get('/content/create/{id}', 'ContentController@createId');
Route::post('/content/store', 'ContentController@store');
Route::get('/content/index','ContentController@index');
Route::get('/content/index/{id}','ContentController@indexSort');
Route::post('/content/update/{id}', 'ContentController@update');
Route::get('/content/edit/{id}', 'ContentController@edit');
Route::any('/content/destroy/{id}', 'ContentController@destroy');

Route::get('/edits/index/{id}','EditsController@index');

Route::get('/subscriptions/index','SubscriptionsController@index');
Route::post('/subscriptions/index','SubscriptionsController@indexPost');
Route::get('/subscriptions/edit/{id}','SubscriptionsController@edit');
Route::post('/subscriptions/update/{id}','SubscriptionsController@update');
Route::get('/reports/index', 'SubscriptionsController@reports');
Route::post('/reports/index', 'SubscriptionsController@reportspost');

//API
Route::get('/api/getCategories', 'ApiController@getCategories');
Route::get('/api/getClasses/{category}', 'ApiController@getClasses');
Route::get('/api/getBooks/{class}', 'ApiController@getBooks');
Route::get('/api/getBooks/{phone}/{accesstoken}', 'ApiController@getBooksSubscribed');
Route::get('/api/getTerms/{phone}/{accesstoken}/{book}', 'ApiController@getTerms');
Route::get('/api/getWeeks/{phone}/{accesstoken}/{book}/{term}', 'ApiController@getWeeks');
Route::get('/api/getLessons/{phone}/{accesstoken}/{book}/{term}/{week}', 'ApiController@getLessons');
Route::get('/api/getContent/{phone}/{accesstoken}/{book}/{term}/{week}/{lesson}', 'ApiController@getContent');
Auth::routes();

Route::get('/home', 'HomeController@index');

//API AUTH
Route::any('/api/createUser/{phone}/{password}','ApiController@createClient');
Route::any('/api/authUser/{phone}/{password}','ApiController@authClient');
Route::any('/api/payments','ApiController@getPayments');
Route::post('/api/readBook','ApiController@readBook');


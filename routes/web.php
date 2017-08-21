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

Route::group(['middleware' => ['auth']], function() {

    Route::get('/home', ['as'=>'home', 'uses'=>'HomeController@index','middleware'=>['permission:view_dashboard']]);


    Route::get('users',['as'=>'users.index','uses'=>'UserController@index','middleware' => ['role:admin_user']]);
    Route::get('users/create',['as'=>'users.create','uses'=>'UserController@create','middleware' => ['role:admin_user']]);
    Route::post('users/create',['as'=>'users.store','uses'=>'UserController@store','middleware' => ['role:admin_user']]);
    Route::get('users/{id}',['as'=>'users.show','uses'=>'UserController@show','middleware'=>['role:admin_user']]);
    Route::get('users/{id}/edit',['as'=>'users.edit','uses'=>'UserController@edit','middleware' => ['role:admin_user']]);
    Route::patch('users/{id}',['as'=>'users.update','uses'=>'UserController@update','middleware' => ['role:admin_user']]);
    Route::delete('users/{id}',['as'=>'users.destroy','uses'=>'UserController@destroy','middleware' => ['role:admin_user']]);

    Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index','middleware' => ['role:admin_user']]);
    Route::get('roles/create',['as'=>'roles.create','uses'=>'RoleController@create','middleware' => ['role:admin_user']]);
    Route::post('roles/create',['as'=>'roles.store','uses'=>'RoleController@store','middleware' => ['role:admin_user']]);
    Route::get('roles/{id}',['as'=>'roles.show','uses'=>'RoleController@show', 'middleware'=>['role:admin_user']]);
    Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'RoleController@edit','middleware' => ['role:admin_user']]);
    Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'RoleController@update','middleware' => ['role:admin_user']]);
    Route::delete('roles/{id}',['as'=>'roles.destroy','uses'=>'RoleController@destroy','middleware' => ['role:admin_user']]);

    Route::get('permissions',['as'=>'permissions.index','uses'=>'PermissionController@index','middleware' => ['role:admin_user']]);
    Route::get('permissions/create',['as'=>'permissions.create','uses'=>'PermissionController@create','middleware' => ['role:admin_user']]);
    Route::post('permissions/create',['as'=>'permissions.store','uses'=>'PermissionController@store','middleware' => ['role:admin_user']]);
    Route::get('permissions/{id}',['as'=>'permissions.show','uses'=>'PermissionController@show','middleware'=>['role:admin_user']]);
    Route::get('permissions/{id}/edit',['as'=>'permissions.edit','uses'=>'PermissionController@edit','middleware' => ['role:admin_user']]);
    Route::patch('permissions/{id}',['as'=>'permissions.update','uses'=>'PermissionController@update','middleware' => ['role:admin_user']]);
    Route::delete('permissions/{id}',['as'=>'permissions.destroy','uses'=>'PermissionController@destroy','middleware' => ['role:admin_user']]);

    Route::get('/subscriptions/index',['as'=>'subscriptions.index', 'uses'=>'SubscriptionsController@index', 'middleware'=>['permission:list_subscriptions']]);
    Route::post('/subscriptions/index',['as'=>'subscriptions.index', 'uses'=>'SubscriptionsController@indexPost', 'middleware'=>['permission:list_subscriptions']]);
    Route::get('/subscriptions/edit/{id}',['as'=>'subscriptions.edit', 'uses'=>'SubscriptionsController@edit', 'middleware'=>['permission:edit_subscriptions']]);
    Route::post('/subscriptions/update/{id}',['as'=>'subscriptions.update', 'uses'=>'SubscriptionsController@update', 'middleware'=>['permission:edit_subscriptions']]);
    Route::get('/reports/index', ['as'=>'reports.index', 'uses'=>'SubscriptionsController@reports', 'middleware'=>['permission:list_reports']]);
    Route::post('/reports/index', ['as'=>'reports.index', 'uses'=>'SubscriptionsController@reportspost','middleware'=>['permission:list_reports']]);

    Route::get('/category/create',['as'=>'category.create','uses'=>'MainController@create','middleware'=>['permission:create_category']]);
    Route::get('/category/index',['as'=>'category.index', 'uses'=>'MainController@index', 'middleware'=>['permission:list_category']]);
    Route::get('/category/clients',['as'=>'category.clients', 'uses'=>'MainController@clients', 'middleware'=>['permission:list_clients']]);
    Route::get('/category/edit/{id}',['as'=>'category.edit', 'uses'=>'MainController@edit', 'middleware'=>['permission:edit_category']]);
    Route::post('/category/store',['as'=>'category.store', 'uses'=>'MainController@store', 'middleware'=>['permission:edit_category']]);
    Route::post('/category/update/{id}',['as'=>'category.update', 'uses'=>'MainController@update', 'middleware'=>['permission:edit_category']]);
    Route::get('/category/activate/{id}',['as'=>'category.activate', 'uses'=>'MainController@activate', 'middleware'=>['permission:activate_category']]);
    Route::any('/category/destroy/{id}', ['as'=>'category.destroy', 'uses'=>'MainController@destroy', 'middleware'=>['permission:delete_category']]);

    Route::get('/class/create',['as'=>'class.create', 'uses'=>'ClassController@create', 'middleware'=>['permission:create_class']]);
    Route::get('/class/create/{id}',['as'=>'class.create', 'uses'=>'ClassController@createId', 'middleware'=>['permission:create_class']]);
    Route::get('/class/index',['as'=>'class.index', 'uses'=>'ClassController@index', 'middleware'=>['permission:list_class']]);
    Route::get('/class/index/{id}',['as'=>'class.index','uses'=>'ClassController@indexSort', 'middleware'=>['permission:list_class']]);
    Route::get('/class/edit/{id}',['as'=>'class.edit','uses'=>'ClassController@edit', 'middleware'=>['permission:edit_class']]);
    Route::post('/class/store',['as'=>'class.store', 'uses'=>'ClassController@store', 'middleware'=>['permission:edit_class']]);
    Route::post('/class/update/{id}',['as'=>'class.update', 'uses'=>'ClassController@update', 'middleware'=>['permission:edit_class']]);
    Route::get('/class/activate/{id}',['as'=>'class.activate', 'uses'=>'ClassController@activate', 'middleware'=>['permission:activate_class']]);
    Route::any('/class/destroy/{id}', ['as'=>'class.destroy', 'uses'=>'ClassController@destroy', 'middleware'=>['permission:delete_class']]);

    Route::get('/book/create', ['as'=>'book.create','uses'=>'BookController@create', 'middleware'=>['permission:create_book']]);
    Route::get('/book/create/{id}', ['as'=>'book.create','uses'=>'BookController@createid', 'middleware'=>['permission:create_book']]);
    Route::post('/book/store', ['as'=>'book.store','uses'=>'BookController@store', 'middleware'=>['permission:create_book']]);
    Route::get('/book/index',['as'=>'book.index','uses'=>'BookController@index', 'middleware'=>['permission:list_book']]);
    Route::get('/book/index/{id}',['as'=>'book.index','uses'=>'BookController@indexSort', 'middleware'=>['permission:list_book']]);
    Route::post('/book/update/{id}', ['as'=>'book.update','uses'=>'BookController@update', 'middleware'=>['permission:edit_book']]);
    Route::get('/book/edit/{id}', ['as'=>'book.edit','uses'=>'BookController@edit', 'middleware'=>['permission:edit_book']]);
    Route::get('/book/activate/{id}',['as'=>'book.activate','uses'=>'BookController@activate', 'middleware'=>['permission:activate_book']]);
    Route::any('/book/destroy/{id}', ['as'=>'book.destroy','uses'=>'BookController@destroy', 'middleware'=>['permission:delete_book']]);

    Route::get('/content/create', ['as'=>'content.create','uses'=>'ContentController@create', 'middleware'=>['permission:create_content']]);
    Route::get('/content/create/{id}', ['as'=>'content.create','uses'=>'ContentController@createid', 'middleware'=>['permission:create_content']]);
    Route::post('/content/store', ['as'=>'content.store','uses'=>'ContentController@store', 'middleware'=>['permission:create_content']]);
    Route::get('/content/index',['as'=>'content.index','uses'=>'ContentController@index', 'middleware'=>['permission:list_content']]);
    Route::get('/content/index/{id}',['as'=>'content.index','uses'=>'ContentController@indexSort', 'middleware'=>['permission:list_content']]);

    Route::post('/content/update/{id}', ['as'=>'content.update','uses'=>'ContentController@update', 'middleware'=>['permission:edit_content']]);
    Route::get('/content/edit/{id}', ['as'=>'content.edit','uses'=>'ContentController@edit', 'middleware'=>['permission:edit_content']]);
    Route::any('/content/destroy/{id}', ['as'=>'content.destroy','uses'=>'ContentController@destroy', 'middleware'=>['permission:delete_content']]);

    Route::get('/edits/index/{id}',['as'=>'edits.index','uses'=>'EditsController@index', 'middleware'=>['permission:list_edits']]);
});

//API
Route::get('/api/getCategories', 'ApiController@getCategories');
Route::get('/api/getClasses/{category}', 'ApiController@getClasses');
Route::get('/api/getBooks/{class}', 'ApiController@getBooks');
Route::get('/api/getBooks/{phone}/{accesstoken}', 'ApiController@getBooksSubscribed');
Route::get('/api/getBooksAll', 'ApiController@getBooksAll');
Route::get('/api/getTerms/{phone}/{accesstoken}/{book}', 'ApiController@getTerms');
Route::get('/api/getPdfs/{phone}/{accesstoken}/{book}', 'ApiController@getPdfList');
Route::get('/api/getPdfFile/{phone}/{accesstoken}/{pdf}', 'ApiController@getPdfFile');

Route::get('/api/datatable/{id}','ApiController@indexList');

Route::get('/api/getWeeks/{phone}/{accesstoken}/{book}/{term}', 'ApiController@getWeeks');
Route::get('/api/getLessons/{phone}/{accesstoken}/{book}/{term}/{week}', 'ApiController@getLessons');
Route::get('/api/getContent/{phone}/{accesstoken}/{book}/{term}/{week}/{lesson}', 'ApiController@getContent');
Route::get('/api/pdf/{phone}/{accesstoken}/{id}', 'ApiController@getPdf');
Route::get('/api/pdfs', 'ApiController@getPdfs');
Auth::routes();

//API AUTH
Route::post('/api/registerUser','ApiController@registerClient');
Route::get('/api/passwordreset/{phone}','ApiController@resetPassword');
Route::get('/api/newpassword/{phone}/{password}/{code}','ApiController@newpassword');
Route::any('/api/authUser/{phone}/{password}','ApiController@authClient');
Route::any('/api/payments','ApiController@getPayments');
Route::post('/api/readBook','ApiController@readBook');

//PesaPal, Unconventional
Route::get('/pesapal', function() {
    //return Redirect::to("Pesapal-iframe.php");
    require(public_path()."/pesapal/Pesapal-iframe.php");
});
Route::get('/pesapalIPN', function() {
    //return Redirect::to("Pesapal-iframe.php");
    require(public_path()."/pesapal/Pesapal-ipn.php");
});
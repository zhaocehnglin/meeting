<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('register','meetcontroller@register');
Route::get("active/{email}/{code}","meetcontroller@active");
Route::post("login","meetcontroller@login");
Route::post("meeting","meetcontroller@meeting");
Route::post("detial/{id}","meetcontroller@detial");
Route::post("addmeet","meetcontroller@addmeet");
Route::post("room","meetcontroller@room'");
Route::post("editroom","meetcontroller@editroom");
Route::get("/",function(){
	return "hello";
});
//Route::get("ceshi","meetcontroller@meeting");
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});

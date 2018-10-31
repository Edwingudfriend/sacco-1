<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('/', function () {
//     return view('layouts.master');
// });

//user routes
Route::get('/adduser', 'UserController@create');
Route::post('/adduser', 'UserController@store');
Route::get('/users', 'UserController@index');
Route::get('/users/edit/{userId}', 'UserController@edit');
Route::patch('/users/{userId}', 'UserController@update');
Route::patch('/usersdelete/{userId}', 'UserController@destroy');
Route::get('/loggedusers', 'UserController@loggedUser');

//next of kin
Route::get('/nextofkin', 'NextofKinController@index');
Route::get('/nextOfKin/edit/{nextofkinId}', 'NextofKinController@edit');
Route::patch('/nextofkin/{nextofkinId}', 'UserController@update');


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/admins','HomeController@adminHome');

//role routes
Route::get('/roles', 'RoleController@index');
Route::get('/role/create', 'RoleController@create');
Route::get('/roles/edit/{id}', 'RoleController@edit');
Route::post('/roles', 'RoleController@store');
Route::post('/userrole/{id}', 'RoleController@storeUserRole');
Route::patch('/roles/{id}', 'RoleController@update');
Route::patch('/roles/{id}', 'RoleController@destroy');

// Savings routes
Route::get('/savings', 'SavingController@index');
Route::get('/savings/create', 'SavingController@create');
Route::post('/search', 'SavingController@search');
Route::post('/savings', 'SavingController@store');
Route::get('/savings/edit/{id}', 'SavingController@edit');
Route::patch('/savings/{id}', 'SavingController@update');
Route::get('/savings/delete/{id}', 'SavingController@destroy');


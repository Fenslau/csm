<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'App\Http\Controllers\MainController@main')
->name('home');

Route::get('/otkazy', 'App\Http\Controllers\OtkazController@main')
->name('otkaz');
Route::get('/otkazy/edit-reasons', 'App\Http\Controllers\OtkazController@editreasons')->can('reason_add')
->name('edit_otkaz_reasons');
Route::get('/otkazy/edit-costs', 'App\Http\Controllers\OtkazController@editcosts')->can('otkaz_cost')
->name('edit_otkaz_costs');
Route::post('/otkazy/edit-reasons/add', 'App\Http\Controllers\OtkazController@reasonadd')->can('reason_add')
->name('reason-add');
Route::post('/otkazy/edit-reasons/del', 'App\Http\Controllers\OtkazController@reasondel')->can('reason_del')
->name('reason-del');
Route::post('/otkazy/new', 'App\Http\Controllers\OtkazController@new')->can('create_otkaz')
->name('new-otkaz');
Route::post('/otkazy/stat', 'App\Http\Controllers\OtkazController@stat')->can('otkaz_stat')
->name('stat-otkaz');


Route::get('/document', 'App\Http\Controllers\DocumentController@main')
->name('document');


Route::get('/procedure', 'App\Http\Controllers\ProcedureController@main')
->name('procedure');


Route::get('/users', 'App\Http\Controllers\UserController@main')->can('create_user')
->name('users');
Route::post('/users/new', 'App\Http\Controllers\UserController@new')->can('create_user')
->name('new-user');
Route::post('/users/search', 'App\Http\Controllers\UserController@search')
->name('user-search');
Route::get('/users/{id}', 'App\Http\Controllers\UserController@id')->can('update_user')
->name('user');
Route::post('/users/{id}/update', 'App\Http\Controllers\UserController@update')->can('update_user')
->name('user-update');
Route::post('/users/{id}/give_roles', 'App\Http\Controllers\UserController@give_roles')->can('create_user')
->name('give_roles');


Route::post('/roles/new', 'App\Http\Controllers\RoleController@new')->can('create_role')
->name('new-role');
Route::post('/roles/del', 'App\Http\Controllers\RoleController@del')->can('create_role')
->name('role-del');
Route::get('/roles/{id}', 'App\Http\Controllers\RoleController@id')->can('create_role')
->name('role');
Route::post('/roles/{id}/give_permissions', 'App\Http\Controllers\RoleController@give_permissions')->can('create_role')
->name('give_permissions');

Route::post('login', 'App\Http\Controllers\Auth\LoginController@login')
->name('login');

Route::get('logout', 'App\Http\Controllers\Auth\LoginController@logout')
->name('logout');

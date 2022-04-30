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
Route::get('/otkazy/edit-reasons', 'App\Http\Controllers\OtkazController@editreasons')
->name('edit_otkaz_reasons');
Route::get('/otkazy/edit-themes', 'App\Http\Controllers\OtkazController@editthemes')
->name('edit_otkaz_themes');
Route::get('/otkazy/edit-costs', 'App\Http\Controllers\OtkazController@editcosts')
->name('edit_otkaz_costs');
Route::post('/otkazy/edit-reasons/add', 'App\Http\Controllers\OtkazController@reasonadd')
->name('reason-add');
Route::post('/otkazy/edit-reasons/del', 'App\Http\Controllers\OtkazController@reasondel')
->name('reason-del');
Route::post('/otkazy/edit-themes/add', 'App\Http\Controllers\OtkazController@themeadd')
->name('theme-add');
Route::post('/otkazy/edit-themes/del', 'App\Http\Controllers\OtkazController@themedel')
->name('theme-del');
Route::post('/otkazy/new', 'App\Http\Controllers\OtkazController@new')
->name('new-otkaz');
Route::get('/otkazy/stat', 'App\Http\Controllers\OtkazController@statistic')
->name('otkaz-stat');
Route::post('/otkazy/get-departments', 'App\Http\Controllers\OtkazController@getdepartments')
->name('get-departments');


Route::get('/journals', 'App\Http\Controllers\JournalController@main')
->name('journals');
Route::get('/journals/holod', 'App\Http\Controllers\Journals\HolodController@main')
->name('journal-holod');
Route::post('/journals/holod/new', 'App\Http\Controllers\Journals\HolodController@new')
->name('new-holod');

Route::get('/journals/lampa', 'App\Http\Controllers\Journals\LampaController@main')
->name('journal-lampa');
Route::post('/journals/lampa/new', 'App\Http\Controllers\Journals\LampaController@new')
->name('new-lampa');
Route::get('/journals/lampa/zamena', 'App\Http\Controllers\Journals\LampaController@narabotka')
->name('narabotka-lamp');
Route::post('/journals/lampa/zamena', 'App\Http\Controllers\Journals\LampaController@zamena')
->name('zamena-lampy');

Route::get('/document', 'App\Http\Controllers\DocumentController@main')
->name('document');


Route::get('/procedure', 'App\Http\Controllers\ProcedureController@main')
->name('procedure');


Route::get('/users', 'App\Http\Controllers\UserController@main')
->name('users');
Route::post('/users/new', 'App\Http\Controllers\UserController@new')
->name('new-user');
Route::post('/users/search', 'App\Http\Controllers\UserController@search')
->name('user-search');
Route::get('/users/{id}', 'App\Http\Controllers\UserController@id')
->name('user');
Route::post('/users/{id}/update', 'App\Http\Controllers\UserController@update')
->name('user-update');
Route::post('/users/{id}/give_roles', 'App\Http\Controllers\UserController@give_roles')
->name('give_roles');


Route::post('/roles/new', 'App\Http\Controllers\RoleController@new')
->name('new-role');
Route::post('/roles/del', 'App\Http\Controllers\RoleController@del')
->name('role-del');
Route::get('/roles/{id}', 'App\Http\Controllers\RoleController@id')
->name('role');
Route::post('/roles/{id}/give_permissions', 'App\Http\Controllers\RoleController@give_permissions')
->name('give_permissions');

Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login')
->name('login');

Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout')
->name('logout');

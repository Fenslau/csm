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
Route::get('/journals/holod/list', 'App\Http\Controllers\Journals\HolodController@list')
->name('journal-holod-list');
Route::get('/journals/holod/del', 'App\Http\Controllers\Journals\HolodController@del')
->name('journal-holod-del');
Route::post('/journals/holod/new', 'App\Http\Controllers\Journals\HolodController@new')
->name('new-holod');
Route::post('/journals/holod/new-holodilnik', 'App\Http\Controllers\Journals\HolodController@newholod')
->name('journal-holod-new');
Route::post('/journals/holod/get-holodilnik', 'App\Http\Controllers\Journals\HolodController@getholodilnik')
->name('get-holodilnik');

Route::get('/journals/lampa', 'App\Http\Controllers\Journals\LampaController@main')
->name('journal-lampa');
Route::post('/journals/lampa/new', 'App\Http\Controllers\Journals\LampaController@new')
->name('new-lampa');
Route::get('/journals/lampa/zamena', 'App\Http\Controllers\Journals\LampaController@narabotka')
->name('narabotka-lamp');
Route::get('/journals/lampa/list', 'App\Http\Controllers\Journals\LampaController@list')
->name('journal-lampa-list');
Route::get('/journals/lampa/del', 'App\Http\Controllers\Journals\LampaController@del')
->name('journal-lampa-del');
Route::post('/journals/holod/new-lampa', 'App\Http\Controllers\Journals\LampaController@newlampa')
->name('journal-lampa-new');
Route::get('/journals/lampa/zamena-lamp', 'App\Http\Controllers\Journals\LampaController@zamena')
->name('zamena-lampy');
Route::post('/journals/holod/get-lampa', 'App\Http\Controllers\Journals\LampaController@getlampa')
->name('get-lampa');

Route::get('/document', 'App\Http\Controllers\DocumentController@main')
->name('document');


Route::get('/procedure', 'App\Http\Controllers\ProcedureController@main')
->name('procedure');


Route::get('/users', 'App\Http\Controllers\UserController@main')
->can('manage_users')->name('users');
Route::post('/users/new', 'App\Http\Controllers\UserController@new')
->name('new-user');
Route::post('/users/search', 'App\Http\Controllers\UserController@search')
->name('user-search');
Route::get('/users/{id}', 'App\Http\Controllers\UserController@id')
->name('user');
Route::post('/users/{id}/update', 'App\Http\Controllers\UserController@update')
->can('manage_users')->name('user-update');
Route::post('/users/{id}/give_roles', 'App\Http\Controllers\UserController@give_roles')
->can('manage_users')->name('give_roles');


Route::post('/roles/new', 'App\Http\Controllers\RoleController@new')
->can('manage_users')->name('new-role');
Route::post('/roles/del', 'App\Http\Controllers\RoleController@del')
->can('manage_users')->name('role-del');
Route::get('/roles/{id}', 'App\Http\Controllers\RoleController@id')
->name('role');
Route::post('/roles/{id}/give_permissions', 'App\Http\Controllers\RoleController@give_permissions')
->can('manage_users')->name('give_permissions');

Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login')
->name('login');

Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout')
->name('logout');

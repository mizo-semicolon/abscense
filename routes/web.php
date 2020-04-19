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



#admin
Route::get('/','admin\admin_controller@show_login_cpanel');
Route::post('/','Auth\LoginController@login');
Route::get('register','Auth\RegisterController@create_admin');
Route::get('dashboard','admin\admin_controller@show_cpanel');
Route::get('logout','Auth\LoginController@logout');
Route::get('add_employee','admin\admin_controller@show_add_employee');
Route::post('add_employee','admin\admin_controller@SaveEmployee');
Route::get('add_prescense/{period}','admin\admin_controller@show_presences');
Route::get('add_prescense/fetch_data', 'admin\admin_controller@fetch_data');
Route::post('/reg_presence','admin\admin_controller@reg_presence');
Route::get('stats','admin\admin_controller@show_stats');
Route::post('stats','admin\admin_controller@show_stats_filter');

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

Route::get('/employees', 'EmployeesController@getEmployeesPage')->middleware('auth');

Route::get('/companies', 'CompaniesController@getCompaniesPage')->middleware('auth');


// Route::get('/', function () {
//     return view('welcome');
// })->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::post('/saveEmployee','EmployeesController@saveEmployee');

Route::get('/getEmployeeList','EmployeesController@getEmployeeList');

Route::post('/delEmployee','EmployeesController@delEmployee');

Route::post('/saveCompany','CompaniesController@saveCompany');

Route::get('/getCompanyList','CompaniesController@getCompanyList');

Route::post('/delCompany','CompaniesController@delCompany');





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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/get_suggestions_for_select2','Select2Controller@GetSuggestionsForSelect2');


Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test', function () {
   return view('attendence.input_fingerprint_data');
});



Route::resource('employees','EmployeesController');

Route::resource('holidays','HolidaysController');

Route::resource('leaves','LeavesController');




//Route::resource('attendence','AttendenceController');
Route::get('input_fingerprint_data','AttendenceController@input_fingerprint_data');
Route::post('attendence/new_sheet','AttendenceController@index');





////////////salarys routes///////////
Route::resource('salaries','SalarysController');

////////Update Budget Allowence

Route::post('/salaries/update_budget_allowence','SalarysController@UpdateBudgetAllowence');



/////////////////ajax
Route::get('/ajax_call','AjaxController@AjaxCall');
Route::post('/ajax_call','AjaxController@AjaxCall');

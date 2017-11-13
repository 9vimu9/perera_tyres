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

//Slapping the keyboard until something good happens.
Route::get('/get_suggestions_for_select2','Select2Controller@GetSuggestionsForSelect2');


Route::get('/home', 'HomeController@index')->name('home');

Route::resource('employees','EmployeesController');

Route::resource('holidays','HolidaysController');

Route::resource('leaves','LeavesController');

Route::resource('features','FeaturesController');

Route::resource('slips','SlipsController');
Route::get('index_with_slips','SlipsController@IndexWithSlips');
Route::get('slips/is_paid/{slip_id}','SlipsController@IsPaid');


Route::get('printouts/slip/{slip_id}','PrintoutsController@PrintSlip');
Route::get('print_all_slips/{salary_id}/{branch_id}','SlipsController@print_all_slips');




Route::resource('attendence','AttendenceController');
Route::get('input_fingerprint_data','AttendenceController@input_fingerprint_data');
Route::post('attendence/new_sheet','AttendenceController@index');
Route::get('attendence_daily_monthly','AttendenceController@attenedence_daily_monthly');






////////////salarys routes///////////
Route::resource('salaries','SalarysController');

////////Update Budget Allowence

Route::post('/salaries/update_budget_allowence','SalarysController@UpdateBudgetAllowence');



/////////////////ajax
Route::get('/ajax_call','AjaxController@AjaxCall');
Route::post('/ajax_call','AjaxController@AjaxCall');

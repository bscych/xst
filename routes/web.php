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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/h5', function(){
     return view('test_h5');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/school', 'SchoolController');
//switch school in case user click anther school
Route::get('/switch/{school_id}','SchoolController@switch')->name('switchSchool');
Route::resource('/user', 'UserController');
Route::resource('/student', 'StudentController');
Route::resource('/course', 'CourseController');
Route::get('/studentList/{course_id}','CourseController@student_list')->name('course.studentList');
Route::resource('/constant', 'ConstantController');
Route::resource('/spend', 'SpendController');
Route::resource('/class', 'ClassmodelController');
Route::get('/students/{class_id}','ClassmodelController@getStudentList')->name('class.studentList');
//income related, manully record income, student pay, 
Route::resource('/income','IncomeController');
Route::get('/selectPaymentCategories/{student_id}','IncomeController@to_select_payment_categories')->name('income.selectPaymentCategories');
Route::get('/studentPayment/{category_id}','IncomeController@to_student_payment')->name('income.studentPayment');
Route::post('/pay','IncomeController@studentPay')->name('income.studentPay');
Route::post('/divide','StudentStatusController@divide')->name('studentStatus.divide');

Route::resource('/schedule','ScheduleController');
Route::get('/getCalendarList','ScheduleController@getCalendarList')->name('schedule.getCalendarList');
Route::get('/scheduleDetailByMonth','ScheduleController@getScheduleDetailByMonth')->name('schedule.month_detail');
Route::get('/lastMonthScheduleDetail','ScheduleController@getLastMonthScheduleDetail')->name('schedule.last_month_detail');
Route::get('/nextMonthScheduleDetail','ScheduleController@getNextMonthScheduleDetail')->name('schedule.next_month_detail');
Route::get('/reCheckIn','ScheduleController@reCheckIn')->name('schedule.reCheckIn');

Route::get('/toBookMeal','ParentController@toBookMeal')->name('parent.bookmeal');
Route::resource('/specialdate','SpecialdateController');

Route::get('/monthList','FinanceController@monthList')->name('finance.monthList');
Route::get('/detail','FinanceController@detail')->name('finance.detail');
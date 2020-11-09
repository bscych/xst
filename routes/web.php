<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckParent;
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
//
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

//微信路由
Route::any('/wechat', 'WeChatController@serve');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware(CheckParent::class);
Route::get('/tutorial', function() {
    return view('tutorial');
})->name('tutorial');

Route::resource('/school', 'SchoolController');
//switch school in case user click anther school
Route::get('/switch/{school_id}', 'SchoolController@switch')->name('switchSchool');
Route::resource('/user', 'UserController');
Route::get('/getMyWorkingSheet', 'UserController@getMyWorkingSheet')->name('user.getMyWorkingSheet');
Route::get('/getTCKListByTeacherId', 'UserController@getTCKListByTeacherId')->name('user.getTCKListByTeacherId');

Route::resource('/student', 'StudentController');
Route::get('/createRegisterCode/{student_id}', 'StudentController@createStudentRegisterCode')->name('student.createRegisterCode');
Route::get('/getRegisterCodes/{student_id}', 'StudentController@getRegisterCodes')->name('student.getRegisterCodes');

Route::resource('/course', 'CourseController');
Route::get('/studentList/{course_id}', 'CourseController@student_list')->name('course.studentList');
Route::resource('/constant', 'ConstantController');
Route::resource('/spend', 'SpendController');
Route::get('/refund', 'SpendController@refund')->name('spend.refund');
Route::post('/returnfee', 'SpendController@returnFee')->name('spend.returnfee');
Route::resource('/classmodel', 'ClassmodelController');

//打印列表
Route::get('/printlist/{class_id}', 'ClassmodelController@getPrintList')->name('classmodel.printlist');
Route::get('/print', 'ClassmodelController@print')->name('classmodel.print');
Route::get('/students/{class_id}', 'ClassmodelController@getStudentList')->name('classmodel.studentList');
//income related, manully record income, student pay, 
Route::resource('/income', 'IncomeController');
Route::get('/selectPaymentCategories/{student_id}', 'IncomeController@to_select_payment_categories')->name('income.selectPaymentCategories');
Route::get('/studentPayment/{category_id}', 'IncomeController@to_student_payment')->name('income.studentPayment');
Route::post('/pay', 'IncomeController@studentPay')->name('income.studentPay');
Route::post('/divide', 'StudentStatusController@divide')->name('studentStatus.divide');



Route::resource('/homework', 'HomeworkController');

Route::resource('/schedule', 'ScheduleController');
Route::get('/getCalendarList', 'ScheduleController@getCalendarList')->name('schedule.getCalendarList');
Route::get('/parentBookMeals', 'ScheduleController@parentBookMeals')->name('schedule.parentBookMeals');
Route::get('/scheduleDetailByMonth', 'ScheduleController@getScheduleDetailByMonth')->name('schedule.month_detail');
Route::get('/lastMonthScheduleDetail', 'ScheduleController@getLastMonthScheduleDetail')->name('schedule.last_month_detail');
Route::get('/nextMonthScheduleDetail', 'ScheduleController@getNextMonthScheduleDetail')->name('schedule.next_month_detail');
Route::get('/reCheckIn', 'ScheduleController@reCheckIn')->name('schedule.reCheckIn');
Route::post('/setAutoBookMeal','ScheduleController@setAutoBookMeal')->name('schedule.autoBookMeal');

Route::resource('/parent', 'ParentController');
Route::get('/toBookMeal', 'ParentController@toBookMeal')->name('parent.bookmeal');
Route::get('/bookingHistory', 'ParentController@bookingHistory')->name('parent.bookingHistory');
Route::get('/findMyKid', 'ParentController@findkid')->name('parent.findMyKid');
Route::get('/registerParent', 'ParentController@register')->name('parent.register');
Route::get('/toRegisterParent', function(){
    return view('wechat.registerEntry');
});
//Route::get('/kidsCourseList','ParentController@kidsCourseList')->name('parent.kidsCourseList');
Route::resource('/specialdate', 'SpecialdateController');

Route::get('/monthList', 'FinanceController@monthList')->name('finance.monthList');
Route::get('/detail', 'FinanceController@detail')->name('finance.detail');

Route::resource('/menu', 'MenuController');
Route::resource('/menuitem', 'MenuitemController');
Route::resource('/event', 'EventController');

Route::resource('/visitor', 'VisitorController');

Route::resource('/payment', 'PaymentController');
Route::resource('/Serviceitem', 'ServiceitemController');

Route::post('/addContactHistory', 'VisitorController@addContactHistory')->name('visitor.addContactHistory');
Route::get('/convertToStudent', 'VisitorController@convertToStudent')->name('visitor.convertToStudent');


Route::get('weixin/token', 'WeChatController@token');
Route::post('weixin/token', 'WeChatController@token');
Route::any('weixin/api', 'WeChatController@api');

Route::group(['middleware' => ['web', 'wechat.oauth']], function () {
    Route::get('wechat_login', 'WeChatController@autoLogin');
//    Route::get('/', function () {
//        $user = session('wechat.oauth_user.default'); // 拿到授权用户资料
//        \Illuminate\Support\Facades\Log::info($user);
//        return view('welcome');
//    })->name('welcome');
  
});





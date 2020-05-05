<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Income;
use App\Model\Constant;
use App\Model\Student;
use App\Http\Controllers\EnrollController;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller {

    public function __construct(StudentStatusController $studentStatusController, EnrollController $enrollController) {
        $this->middleware('auth');
        $this->authorizeResource(Income::class);
        $this->enrollController = $enrollController;
        $this->studentStatusController = $studentStatusController;
    }

    protected $enrollController;
    protected $studentStatusController;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $incomes = Income::where('school_id', session()->get('school_id'))->paginate(10);
        return view('income.index', ['incomes' => $incomes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $name_of_accounts = \App\Model\Constant::whereNotIn('id', function($query) {
                    $query->select('id')->from('Constants')->where([['name', 'like', '%_fee']]);
                })->where('parent_id', 4)->get();
        return view('income.create', ['name_of_accounts' => $name_of_accounts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $rules = array(
            'name' => 'required',
            'name_of_account' => 'required',
            'amount' => 'required|numeric|min:0',
            'finance_year' => 'required',
            'finance_month' => 'required'
        );
        $validator = validator($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('spend/create')->withErrors($validator);
        } else {
            $this->createNewIncome();
            return $this->index();
        }
    }

    function createNewIncome() {
        $income = new Income;
        if (request()->input('name') === null) {
            $income->name = (request()->input('which_day') === null ? now()->format('Y-m-d') : request()->input('which_day')) . Student::find(session()->get('student_id'))->name . '，交费课程：' . Constant::find(request()->input('name_of_account'))->label_name . '，交费金额：' . request()->input('amount');
            $income->paid_by = session()->get('student_id');
        } else {
            $income->name = request()->input('name');
        }
        $income->name_of_account = request()->input('name_of_account');
        $income->amount = request()->input('amount');
        $income->payment_method = request()->input('payment_method') == null ? '微信' : request()->input('payment_method');
        $income->which_day = request()->input('which_day') == null ? \Illuminate\Support\Carbon::now() : request()->input('which_day');
        $income->finance_year = request()->input('finance_year');
        $income->finance_month = request()->input('finance_month');
        $income->comment = request()->input('comment');
        $income->operator = auth()->id();
        $income->school_id = session()->get('school_id');
        $income->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    public function to_select_payment_categories($student_id) {
        session()->put('student_id', $student_id);
        $incomesCategories = Constant::where([['parent_id', 4], ['name', 'like', '%_fee']])->get();
        return view('income.show_payment_categories', ['incomesCategories' => $incomesCategories]);
    }

    public function to_student_payment($category_id) {
        $category = Constant::find($category_id);
        $student = Student::find(session()->get('student_id'));
        $paymentMethods = Constant::where('parent_id', 1)->get();
        $courses = null; //预存保存至学生账户pre_fee, meal_fee,不需要与课程绑定，所以$courses=null      
        if ($category->name === 'tuoguan_fee') {
            $courses = \App\Model\Course::where([['is_speciality_course', '0'], ['school_id', session()->get('school_id')]])->get(); //筛选出不是特长课的课程。
        }
        //特长课要显示具体班级
        if ($category->name === 'speciality_course_fee') {
            $courses = DB::table('classmodels')->join('courses', 'courses.id', '=', 'classmodels.course_id')->where([['courses.deleted_at', '=', null], ['courses.is_speciality_course', '1'], ['classmodels.deleted_at', '=', null],['school_id', session()->get('school_id')]])->select('courses.name as course_name', 'classmodels.name as class_name', 'classmodels.id')->orderBy('courses.created_at', 'desc')->get();
        }
        return view('income.student_pay')
                        ->with('student', $student)
                        ->with('paymentMethods', $paymentMethods)
                        ->with('courses', $courses)
                        ->with('incomesCategory', $category);
    }

    public function studentPay(Request $request) {
        $student = Student::find(session()->get('student_id'));
        $incomeCategory = Constant::find($request->input('name_of_account'));
        $rules = array('amount' => 'required',);
        $validator = validator($request->all(), $rules);
        if ($validator->fails()) { return redirect('income/create?student_id=' . $student->id)->withErrors($validator);
        } else {
            //ot create an income record
            $this->createNewIncome();
            //预存到学生个人账户
            $this->enrollController->saveToStudentAccount();
            //非预存操作，需要保存扣费记录
            if ($incomeCategory->name != 'pre_fee') {
//                校验学生账户余额是否够扣，不够扣，返回缴费页面，并提示余额不足，如果够扣，扣费报课
                $balance = $this->enrollController->deduct($request);
                if ($balance >= 0) {
                    $this->studentStatusController->put_student_into_class();
                } else {
                    $validator->errors()->add('balance', '余额不足，请再充值' . (0 - $balance));
                    return redirect(route('income.create', ['student_id' => $student->id, 'category' => $incomeCategory->name])->withErrors($validator));
                }
            }
            return redirect(route('student.index'));
        }
    }

}
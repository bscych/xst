<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Spend;
use App\Model\Constant;
use App\Model\Refund;
use App\Model\Student;
use Illuminate\Support\Facades\DB;

class SpendController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->authorizeResource(Spend::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $spends = Spend::where('school_id', session()->get('school_id'))->where('finance_year','>',2019)->orderByDesc('created_at')->paginate(10);
        return view('spend.index')->with('spends', $spends);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('spend.create')->with('name_of_accounts', Constant::where('parent_id', 3)->get());
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
            $spend = new Spend;
            $spend->name = $request->input('name');
            $spend->name_of_account = $request->input('name_of_account');
            $spend->amount = $request->input('amount');
            $spend->payment_method = $request->input('payment_method') == null ? '微信' : $request->input('payment_method');
            $spend->which_day = $request->input('which_day') == null ? date("Y-m-d", time()) : $request->input('which_day');
            $spend->finance_year = $request->input('finance_year');
            $spend->finance_month = $request->input('finance_month');
            $spend->comment = $request->input('comment');
            $spend->operator = auth()->id();
            $spend->school_id = session()->get('school_id');
            $spend->save();
            return $this->index();
        }
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
    /*
     * 退费管理，返回退费页面
     */
    public function refund(Request $request) {
          $student = \App\Model\Student::find($request->input('student_id'));
   
        return view('spend.refund.create')
                ->with('student',$student)
                ->with('paymentMethods',Constant::where('parent_id', 1)->get())
                ->with('refundCategories',Constant::where('parent_id',6)->get());
    }
/*
 * 退钱操作
 */
     public function returnFee(Request $request) {
        $student_id = $request->input('student_id');
        $category_id = $request->input('category_id');
        $course_id = $request->input('course_id');
        $amount = $request->input('amount');
        $payment_method = $request->input('payment_method');
        $finance_year = $request->input('finance_year');
        $finance_month = $request->input('finance_month');
        $comment = $request->input('comment')===null?' ':$request->input('comment');
        
        $refund = new Refund;
        $refund->name = date("Y-m-d", time()) . Student::find($student_id)->name . "退费" . $amount;
        $refund->school_id = session()->get('school_id');
        $refund->course_id = $course_id;
        $refund->student_id = $student_id;
        $refund->name_of_account = $category_id;
        $refund->amount = $amount;
        $refund->payment_method = $payment_method;
        $refund->finance_year = $finance_year;
        $refund->finance_month = $finance_month;
        $refund->comment = $comment;
        $refund->operator = auth()->user()->id;
        $refund->save();
        if($request->input('quit_class')==='1'){
             DB::table('course_student')->where([['course_id',$course_id],['student_id',$student_id]])->update(['deleted_at'=> \Illuminate\Support\Carbon::now(),'classmodel_id'=>null]);
        }
      
        if($category_id==34){//返现
            $spend = new Spend;
            $spend->name =  $refund->name;
            $spend->school_id = session()->get('school_id');
            $spend->name_of_account = Constant::where('label_name','退费')->first()->id;//使用支出会计科目的退费
            $spend->amount =$refund->amount;
            $spend->payment_method =  $refund->payment_method;
            $spend->which_day = date("Y-m-d", time());
            $spend->finance_year = $refund->finance_year;
            $spend->finance_month = $refund->finance_month;
            $spend->comment = $refund->comment;
            $spend->operator = auth()->user()->id;
            $spend->save();
            
        }else{//返回个人账户
            $balance = Student::find($student_id)->balance;
            Student::where('id',$student_id)->update(['balance'=>$balance+$amount]); 
        }
         return redirect()->to('student');
        
    }
    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Student;
use App\Model\Enroll;
/*
 * the class is for student fee related operations, including pre_fee
 * 
 */
class EnrollController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveToStudentAccount() {
        $student = Student::find(session()->get('student_id'));
        $student->balance = $student->balance + request()->input('amount');
        $student->save();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deduct(Request $request) {
        $needed = $request->input('amount');
        $student = Student::find(session()->get('student_id'));
        $incomeCategory = \App\Model\Constant::find($request->input('name_of_account'));
        $moreNeeded = $student->balance - $needed ;
        if ($moreNeeded >= 0) {
            $enroll = new Enroll;
            $enroll->income_account = $incomeCategory->id;
            $enroll->name = '扣除'.$incomeCategory->label_name.':'.$needed;
            $enroll->course_id = $request->input('course_id');
            $enroll->student_id = session()->get('student_id');
            $enroll->paid = $needed;            
            $enroll->operator = auth()->id();
            $enroll->school_id = session()->get('school_id');
            $enroll->save();
            
            $student->balance = $student->balance - $enroll->paid;
            $student->save();
            $moreNeeded = $student->balance;
        }
        return $moreNeeded;
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

}

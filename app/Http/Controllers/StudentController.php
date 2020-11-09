<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Student;
use Illuminate\Support\Facades\Crypt;
class StudentController extends Controller {

    public function __construct() {
        $this->middleware('auth');
//        $this->authorizeResource(Student::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $this->authorize('viewAny',Student::class);
        $name = $request->input('name');
        $students = Student::where('name', 'like', '%' . $name . '%')
                        ->whereIn('id', function($query) {
                            $query->from('school_student')->where('school_id', session()->get('school_id'))->select('student_id')
                            ->get();
                        })->orderByDesc('created_at')->paginate(15);
        return view('student.index')->with('students', $students);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('student.create')->with('schools', \App\Model\Constant::where('parent_id', 44)->where('school_id', session()->get('school_id'))->get());
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
            'gender' => 'required',
            'birthday' => 'required',
            'grade' => 'required',
            'class_room' => 'required',
        );
        $validator = validator($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect('student/create')
                            ->withErrors($validator);
        } else {
            $student = $this->formStudent(null);
            $student->save();
            DB::table('school_student')->insert(['school_id' => session()->get('school_id'), 'student_id' => $student->id,'created_at'=>now()]);
            return redirect('/student');
        }
    }

    /*
     * form a student
     */

    function formStudent($id) {
        $student = new \App\Model\Student;
        if ($id != null) {
            $student = Student::find($id);
        }
        $student->name = request('name');
        $student->gender = request('gender');
        $student->birthday = request('birthday');
        $student->nation = request('nation');
        $student->health = request('health');
        $student->interest = request('interest');
        $student->home_address = request('home_address');
        $student->parents_info = Crypt::encryptString(request('parents_info'));
        $student->constant_school_id = (int)request('constant_school_id');
        $student->grade = request('grade');
        $student->class_room = request('class_room');
        $student->class_supervisor_name = request('class_supervisor_name');
        $student->class_supervisor_phone = request('class_supervisor_phone');
        $student->chinese = request('chinese');
        $student->math = request('math');
        $student->english = request('english');
        $student->study_brief = request('study_brief');
        $student->live_brief = request('live_brief');
        $student->character_brief = request('character_brief');
        $student->expectation = request('expectation');
        $student->expect_courses = request('expect_courses');
        $student->operator = auth()->id();
        return $student;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $payments = DB::table('incomes')
                ->join('constants as incomeCategory', 'incomeCategory.id', 'incomes.name_of_account')
                ->select('incomes.name', 'incomes.amount', 'incomeCategory.label_name as income_name', 'incomes.payment_method', 'incomes.comment', 'incomes.created_at')
                ->where('incomes.school_id', session('school_id'))
                ->where('incomes.paid_by', $id)
                ->orderBy('created_at', 'desc')
                ->get();
        $enroll = DB::table('enrolls')
                ->join('constants', 'constants.id', 'enrolls.income_account')
                ->select('enrolls.paid', 'constants.label_name as income_account', 'enrolls.name as enrolls_name', 'enrolls.created_at')
                ->where('enrolls.school_id', session('school_id'))
                ->where('student_id', '=', $id)
                ->orderBy('enrolls.created_at', 'desc')
                ->get();
        $refunds = DB::table('refunds')
                ->join('constants', 'constants.id', 'refunds.name_of_account')
                ->join('courses', 'refunds.course_id', 'courses.id')
                ->select('refunds.amount', 'courses.name as course_name', 'constants.label_name as refund_category', 'refunds.created_at', 'refunds.comment')
                ->where('refunds.school_id', session('school_id'))
                ->where('student_id', '=', $id)
                ->get();

        $courses = $this->getActiveCourseList($id);
//decrypt student's parent's information expecially phone number
        $dStudent = Student::find($id);
        if($dStudent->parents_info!=null){
             $dStudent->parents_info = Crypt::decryptString($dStudent->parents_info);
        }
//        $refunds = DB::table('refunds')
//                ->join('constants');
        return view('student.detail')
                        ->with('student', $dStudent)
                        ->with('payments', $payments)
                        ->with('enrolls', $enroll)
                        ->with('refunds', $refunds)
                        ->with('balance', Student::find($id)->balance)
                        ->with('courses', $courses);
    }
    
    private  function getActiveCourseList($studentId) {
        $claz = DB::table('course_student')
                ->join('courses', 'course_student.course_id', 'courses.id')
                ->join('classmodels','course_student.classmodel_id','classmodels.id')
                ->where([['course_student.student_id', '=', $studentId], ['course_student.deleted_at', '=', null], ['courses.deleted_at', '=', null], ['course_student.classmodel_id', '<>', null],['classmodels.deleted_at','=',null]])
                //the last condition is to find the course started earlier than today 
                ->select('course_student.classmodel_id', 'courses.id', 'courses.name', 'courses.is_speciality_course','course_student.how_many_left')
                ->get();
        return $claz;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $student = Student::find($id);
        $this->authorize('update', $student);      
        if($student->parents_info!=null){
             $student->parents_info = Crypt::decryptString($student->parents_info);
        }
        return view('student.edit',['student'=>$student,'schools'=> \App\Model\Constant::where('parent_id',44)->where('school_id', session('school_id'))->get()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $rules = array(
            'name' => 'required',
            'gender' => 'required',
            'birthday' => 'required',         
            'grade' => 'required',
            'class_room' => 'required',
        );
        $validator = validator($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect('student/create')
                            ->withErrors($validator);
        } else {
            $student = $this->formStudent($id);
            $student->save();           
            return redirect('/student');
        }
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
    
    
    public function getRegisterCodes($student_id) {
        $student = Student::find($student_id);
        $registerCodes = DB::table('register_codes')->where('student_id', $student_id)->get();
        return view('student.register_code')->with('student', $student)->with('registerCodes', $registerCodes);
    }
    
    public function createStudentRegisterCode($student_id) {
        $code = $this->generateCode();
        $isThere = DB::table('register_codes')->where('code',$code)->get();
        
        while ($isThere->isNotEmpty()) {
            $code = $this->generateCode();
            $isThere = DB::table('register_codes')->where('code',$code)->get();
        }
        
        DB::table('register_codes')->insert(['school_id'=> session()->get('school_id'),'student_id'=>$student_id,'code'=>$code,'created_at'=> \Illuminate\Support\Carbon::now(),'updated_at'=> \Illuminate\Support\Carbon::now()]);
        return $this->getRegisterCodes($student_id);
    }
    
    private function generateCode() {
        return str_pad(mt_rand(0, 999999), 6, "0", STR_PAD_BOTH);
    }

}

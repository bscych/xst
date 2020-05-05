<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Model\Student;

class StudentController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->authorizeResource(Student::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $name = $request->input('name');
        $students = Student::where('name', 'like','%'. $name . '%')
                ->whereIn('id',function($query) {
                $query->from('school_student')->where('school_id', session()->get('school_id'))->select('student_id')
                      ->get();
            })->get();
        return view('student.index')->with('students', $students);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
          $rules = array(
            'name' => 'required|unique:students',
            'gender' => 'required',
            'birthday' => 'required',
        );
        $validator = validator($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect('student/create')
                            ->withErrors($validator);
        } else {
            $student = $this->formStudent(null);
            $student->save();
            DB::table('school_student')->insert(['school_id'=> session()->get('school_id'),'student_id'=>$student->id]);
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
        $student->school = request('school');
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

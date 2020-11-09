<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Classmodel;
use App\Model\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
class ClassmodelController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->authorizeResource(Classmodel::class, 'classmodel');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {     
        $course_id = request()->input('course_id');
        if ($course_id != null) {
            $classes = Classmodel::where([['course_id', $course_id]])->get();
        } else {
            $classes = Classmodel::where('teacher_id', auth()->id())->whereIn('course_id', function ($query) {
                        $query->from('courses')->where([['school_id', session('school_id')], ['deleted_at', null]])->select('id');
                    })->get();
        }
        return view('class.index', ['classes' => $classes, 'course_id' => $course_id]);
    }
    
   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $course_id = request()->input('course_id');
        $course = \App\Model\Course::find($course_id);
        if ($course != null) {
            $teachers = \App\User::whereIn('id', function ($query) {
                        $query->select('user_id')->from('user_has_role_in_school')->whereIn('constant_id', [48, 49])->where('school_id', session()->get('school_id'));
                    })->get();
            return view('class.create', ['teachers' => $teachers, 'course' => $course]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $course = Course::find($request->input('course_id'));
        $rules = array(
            'name' => 'required',
            'start_date' => 'required|date',
        );
        $validator = validator($request->all(), $rules);
        // process the login
        if ($validator->fails()) {
            return redirect(route('class.create', ['course_id' => $course->id]))
                            ->withErrors($validator);
        } else {
            $claz = new Classmodel;
            $claz->course_id = $course->id;
            $claz->name = $request->input('name');
            $claz->teacher_id = $request->input('teacher_id');
            $claz->start_date = $request->input('start_date');
            $claz->end_date = $request->input('end_date');
            $weekdays = collect();
            for ($i = 0; $i < 7; $i++) {
                if ($request->input('' . $i) == 'on') {
                    $dayArr = ['day'=>$i,'time'=>['start_at'=>null,'end_at'=>null]]; 
                    Arr::set($dayArr, 'time.start_at', $request->input($i.'_s'));
                    Arr::set($dayArr, 'time.end_at', $request->input($i.'_e'));
                    $weekdays->push($dayArr);
                }
            }
            $claz->which_days = $weekdays->toJson();
            $claz->save();
            return redirect(route('classmodel.index', ['course_id' => $claz->course_id]));
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
    public function edit(Classmodel $classmodel) {
        $teachers = \App\User::whereIn('id', function ($query) {
                    $query->select('user_id')->from('user_has_role_in_school')->whereIn('constant_id', [48, 49])->where('school_id', session()->get('school_id'));
                })->get();
        $classmodel->which_days = collect(json_decode($classmodel->which_days));
        return view('class.edit', ['class' => $classmodel, 'teachers' => $teachers]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classmodel $classmodel) {
       
        $rules = array(
            'name' => 'required',
            'start_date' => 'required|date',
        );
        $validator = validator($request->all(), $rules);
        // process the login
        if ($validator->fails()) {
            return redirect(route('class.edit', ['course_id' => $course->id]))
                            ->withErrors($validator);
        } else {
            $claz = Classmodel::find($classmodel->id);          
            $claz->name = $request->input('name');
            $claz->teacher_id = $request->input('teacher_id');
            $claz->start_date = $request->input('start_date');
            $claz->end_date = $request->input('end_date');
            $weekdays = collect();
            for ($i = 0; $i < 7; $i++) {
                if ($request->input('' . $i) == 'on') {
                    $weekdays->push($i);
                }
            }
            $claz->which_days = $weekdays->toJson();
            $claz->save();
            return $this->index();
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

//    
    public function getStudentList($class_id) {
        return view('class.studentList', ['class' => Classmodel::find($class_id), 'threshold' => \App\Model\School::find(session('school_id'))->threshold]);
    }
    
    /*
     * 
     */

    public function getPrintList($id) {
         $students = $this->getStudentsByClassId($id);
        $homeworks = $this->getTodayHomework();
        return view('class.print_list', ['students' => $students, 'homeworks' => $homeworks, 'classmodel_id' => $id]);
    }
    
    
    private function getStudentsByClassId($class_id) {
        $students = DB::table('schedules')
                        ->join('students', 'schedules.student_id', 'students.id')                     
                        ->where([['schedules.classmodel_id', $class_id],['schedules.date',now()->format('Y-m-d')]])
                        ->select('students.id', 'students.name','students.constant_school_id', 'students.grade', 'students.class_room','schedules.attend','schedules.lunch','schedules.dinner')->get();
        return $students;
    }

    private function getTodayHomework() {
        $today = now()->format('Y-m-d');
        return \App\Model\Homework::where('date', $today)->get();
    }
    
    public function print(Request $request) {
         $student_id = $request->input('student_id');
        $class_id = $request->input('class_id');      
        $students = $this->getStudentsByClassId($class_id);
        if ($student_id != null) {//print a single student's homework
            $student = $students->where('id',$student_id)->first();
            $students = collect();
            $students->push($student);
        }
        $attend_students = $students->where('attend','1')->all();
        $homeworks = $this->getTodayHomework();
//        $notes = \App\Model\Parentnote::where('date',now()->format('Y-m-d'))->get();
        $printable_students = collect();
        foreach($attend_students as $std){
            if($homeworks->where('constant_school_id',$std->constant_school_id)->where('grade',$std->grade)->where('class',$std->class_room)->first()!=null){
                $printable_students->push($std);
            }
        }
        return view('class.student_homework', ['students' => $printable_students, 'homeworks' => $homeworks]);
    }
}

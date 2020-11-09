<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Course;

class CourseController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->authorizeResource(Course::class,'course');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $courses = Course::where([['school_id', session()->get('school_id')]])->get();  
        return view('course.index')->with('courses', $courses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('course.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator  = validator($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'is_speciality_course'=>['required']
        ]);
        if ($validator->fails()) {
            return redirect(route('course.create'))->withErrors($validator);
        } else {
            $course = new Course();
            $course->name = $request->input('name');
            $course->unit = $request->input('unit')===null?'':$request->input('unit');
            $course->unit_price = $request->input('unit_price')===null?0:$request->input('unit_price');
            $course->duration = $request->input('duration')===null?'0':$request->input('duration');
            $course->in_count = $request->input('in_count');
            $course->has_dinner = $request->input('has_dinner');
            $course->has_lunch = $request->input('has_lunch');
            $course->has_snack = $request->input('has_snack');
            $course->school_id = session()->get('school_id');
            $course->created_by = auth()->id();
            $course->is_speciality_course = (int)$request->input('is_speciality_course');
            $course->save();
            return $this->index();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course) {
      return view('course.edit')->with('model',$course);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course) {
       $validator  = validator($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'is_speciality_course'=>['required']
        ]);
        if ($validator->fails()) {
            return redirect(route('course.edit', $course))->withErrors($validator);
        } else {
            $cors = Course::find($course->id);
            $cors->name = $request->input('name');
            $cors->unit = $request->input('unit');
            $cors->unit_price = $request->input('unit_price');
            $cors->duration = $request->input('duration');
            $cors->in_count = $request->input('in_count');
            $cors->has_dinner = $request->input('has_dinner');
            $cors->has_lunch = $request->input('has_lunch');
            $cors->has_snack = $request->input('has_snack');
            $cors->school_id = session()->get('school_id');
            $cors->created_by = auth()->id();
            $cors->is_speciality_course = (int)$request->input('is_speciality_course');
            $cors->save();
            return $this->index();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course) {
        //
    }
    
    public function student_list($id) {   
        $this->authorize('studentList', Course::class);
        $course = Course::find($id);   
        
        return view('course.studentList',['course'=> $course]);
    }

}

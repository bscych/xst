<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Course;

class CourseController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->authorizeResource(Course::class);
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
            $course->unit = $request->input('unit');
            $course->unit_price = $request->input('unit_price');
            $course->duration = $request->input('duration');
            $course->in_count = $request->input('in_count');
            $course->has_dinner = $request->input('has_dinner');
            $course->has_lunch = $request->input('has_lunch');
            $course->has_snack = $request->input('has_snack');
            $course->school_id = session()->get('school_id');
            $course->created_by = auth()->id();
            $course->is_speciality_course = $request->input('is_speciality_course');
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
    
    public function student_list($id) {
        $course = Course::find($id);
        $this->authorize('studentList', $course);
        return view('course.studentList',['course'=> $course]);
    }

}

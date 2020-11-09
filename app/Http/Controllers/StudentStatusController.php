<?php

namespace App\Http\Controllers;

use App\Model\Constant;
use Illuminate\Support\Facades\DB;

/*
 * 
 * the class is for student status related operation including enroll into class, quit class
 */

class StudentStatusController extends Controller {
    /*
     * after fee is deducted, student is put into a certain class(or course)
     */

    public function put_student_into_class() {
        $student_id = session()->get('student_id');
        $course_id = request()->input('course_id');
        $how_many_left = request()->input('how_many_left');
        $incomeCategory = Constant::find(request()->input('name_of_account'));
        //托管交费
        if ($incomeCategory->name === 'tuoguan_fee') {
            $coure_students = DB::table('course_student')->where([['course_id', '=', $course_id], ['student_id', '=', $student_id]])->get();
            if ($coure_students->isEmpty()) {
                DB::table('course_student')->insert(['course_id' => $course_id, 'student_id' => $student_id, 'school_id' => session()->get('school_id')]
                );
            }
        }
        //特长课交费
        if ($incomeCategory->name === 'speciality_course_fee') {
            $classModel = \App\Model\Classmodel::find($course_id);
            $old_how_many_left = DB::table('course_student')->where([['classmodel_id', $course_id], ['course_id', $classModel->course_id], ['deleted_at', null], ['student_id', $student_id], ['school_id', session()->get('school_id')]])->get()->first();
            if ($old_how_many_left == null) {
                DB::table('course_student')->insert(['classmodel_id' => $course_id, 'course_id' => $classModel->course_id, 'deleted_at' => null, 'student_id' => $student_id, 'how_many_left' => $how_many_left, 'school_id' => session()->get('school_id')]);
            } else {
                DB::table('course_student')->where(['classmodel_id' => $course_id, 'course_id' => $classModel->course_id, 'deleted_at' => null, 'student_id' => $student_id])->update(['how_many_left' => $old_how_many_left->how_many_left + $how_many_left]);
            }
        }
    }

    public function divide() {
        $course_id = request('course_id');
        $student_id = request('student_id');
        $class_id = request('class_id');
        //see if there is a recorder of that student in the class
        $course_student = DB::table('course_student')->where([['course_id', '=', $course_id], ['student_id', '=', $student_id],])->get();
        if ($course_student->count() === 0) {
            //not recorder to insert one
            DB::table('course_student')->insert(['course_id' => $course_id, 'student_id' => $student_id, 'classmodel_id' => $class_id]);
        } else {
            //do have the update the classmodel id instead
            DB::table('course_student')->where('id', $course_student->first()->id)->update(['classmodel_id' => $class_id]);
        }
        return redirect('studentList/' . $course_id);
    }

    public function refund() {
        
    }

}

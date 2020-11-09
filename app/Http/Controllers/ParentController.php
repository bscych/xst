<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SchoolController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ParentController extends Controller {

    public function __construct(SchoolController $schoolController) {
        $this->middleware('auth');
        $this->schoolController = $schoolController;
    }

    protected $schoolController;

    public function swtich($school_id) {
        $this->schoolController->switch($school_id);
    }

    /*
     * 为孩子预约订餐
     * if there is only one 托管课程 ongoing, go to booking page
     * if there are more than one, user should pick up a course to book meal
     * if there is no 托管课程，user can not book meals
     */

    public function toBookMeal() {
        if ($this->hasRegistered()) {
            $user = auth()->user();
            $student_id = request('student_id');
            if ($user->myKids->count() > 1 and $student_id === null) {
                return $this->kidList($user->myKids);
            } else {
                $student = $student_id != null ? \App\Model\Student::find($student_id) : \App\Model\Student::find($user->myKids->first()->id);
                $claz = $this->getTGCourseByStudent($student);
                if ($claz->count() === 1) {
                    return redirect(route('schedule.parentBookMeals', ['student_id' => $student->id, 'classmodel_id' => $claz->first()->id]));
                } else if ($claz->count() === 0) {
                    return view('parent.can_not_book_meal')->with('student', $student);
                } else {
                    return view('parent.kidsCourseList')->with('classmodels', $claz)->with('student_id', $student->id);
                }
            }
        } else {
            return $this->toRgister();
        }
    }

    /*
     * return kid list in case there are more than one kid from the family
     */

    public function kidList($kidList) {
        if ($this->hasRegistered()) {
            return view('parent.kidList', ['kids' => $kidList]);
        } else {
            return $this->toRgister();
        }
    }

    /*
     * 孩子的课程列表
     */

    private function kidsCourseList() {
        $user = auth()->user();
        if ($user->myKids->count() === 1) {
            return view('parent.kidsCourseList')->with('student', $user->myKids->first());
        }
        if (auth()->user()->myKids->count() > 1) {
            return $this->kidList(auth()->user()->myKids);
        }
    }

    /*
     * 孩子的订餐记录
     */

    public function bookingHistory() {
        if ($this->hasRegistered()) {
            $user = auth()->user();
            $student_id = request('student_id');
            if ($user->myKids->count() > 1 and $student_id === null) {
                return $this->kidList($user->myKids);
            } else {
                $student = $student_id != null ? \App\Model\Student::find($student_id) : \App\Model\Student::find($user->myKids->first()->id);
                $claz = $this->getTGCourseByStudent($student);
                if ($claz->count() === 1) {
                    return redirect(route('schedule.month_detail', ['student_id' => $student->id, 'classmodel_id' => $claz->first()->id]));
                } else if ($claz->count() === 0) {
                    return view('parent.can_not_book_meal')->with('student', $student);
                } else {
                    return view('parent.kidsCourseList')->with('classmodels', $claz)->with('student_id', $student->id);
                }
            }
        } else {
            return $this->toRgister();
        }
    }

    /*
     * get kid's booking histotry by student_id
     */

    private function getTGCourseByStudent($student) {
        if (!$this->hasRegistered()) {
            return $this->toRgister();
        }
        $claz = collect();
        foreach ($student->classmodels as $classmodel) {
            $classStart_date = \Illuminate\Support\Carbon::make($classmodel->start_date)->format('Y-m-d');
            $ClassClosed_date = \Illuminate\Support\Carbon::make($classmodel->end_date)->format('Y-m-d');
            //当天学生有托管课，当天大于课程开始时间，并且当天小于课程结束时间，并且课程是托管课程
            if (now() > $classStart_date and $classmodel->course->is_speciality_course === 0 and $classmodel->deleted_at === null) {
                $claz->add($classmodel);
            }
        }
        return $claz;
    }

    public function findkid() {
        return $this->toRgister();
    }

    public function hasRegistered() {
        $kids = auth()->user()->myKids;
        return $kids->count() > 0;
    }

    private function toRgister() {
        return view('parent.register');
    }

    public function store(Request $request) {
        $rules = array('code' => 'required|exists:register_codes',);
        $validator = validator()->make($request->all(), $rules);
        // process the login
        if ($validator->fails()) {
            return redirect()->route('showParentRegisterForm')
                            ->withErrors($validator);
        }
        //verify student is there, 
        $code = $request->input('code');
        $relationship = $request->input('relationship');
        $student_id = $this->verifyCode($code, $relationship);
        if ($student_id == null) {
            return '该验证码不存在';
        } else {
            //create a new user or find existing user
            $user = auth()->user();
//            $user->roles->where('id',50)->count() > 0 ?: $user->assignRole('parent');
            //log in the new user
//            Auth::loginUsingId($user->id);
            //update parent_student table, setup user and student relationship
            DB::table('parent_student')->insert(['school_id' => session()->get('school_id'), 'user_id' => $user->id, 'student_id' => $student_id, 'relationship' => $relationship, 'created_at' => Carbon::now()]);
            return redirect()->route('home');
        }
    }

    function verifyCode($code, $relationship) {
        $students = DB::table('register_codes')
                ->join('students', 'students.id', 'register_codes.student_id')
                ->where('register_codes.deleted_at', null)
                ->where('register_codes.code', $code)
                ->where('school_id', session()->get('school_id'))
                ->select('students.id')
                ->get();
        if ($students->count() == 1) {
            DB::table('register_codes')->where('code', $code)->update(['relationship' => $relationship, 'deleted_at' => Carbon::now()]);
            return $students->first()->id;
        }
        return null;
    }
    
    public function register() {
      return $this->toRgister();
    }

}

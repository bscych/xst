<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\User;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('auth');
//        $this->authorizeResource(User::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->authorize('viewAny', User::class);
        if(session()->get('school_id')===0){
             $users = User::whereIn('id', function ($query) {
                    $query->select('user_id')->from('user_has_role_in_school')->where('school_id', session()->get('school_id'))->orWhere('school_id',null);
                })->orderBy('users.created_at', 'desc')->paginate(15);
        }else{
             $users = User::whereIn('id', function ($query) {
                    $query->select('user_id')->from('user_has_role_in_school')->where('school_id', session()->get('school_id'));
                })->orderBy('users.created_at', 'desc')->paginate(15);
        }    
        return view('user.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
         $this->authorize('create', User::class);
        if(session()->get('school_id')===0){
             $roles = \App\Model\Constant::where('parent_id', 5)->whereIn('id',[46,47])->get();
        }else{
             $roles = \App\Model\Constant::where('parent_id', 5)->whereNotIn('id',[46,47,52,51])->get();
        }
       
        return view('user.create')->with('roles', $roles)->with('school_id', session()->get('school_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
         $this->authorize('create', User::class);
        $validator = Validator::make($request->all(), [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails()) {
            return Redirect::to(route('user.index'))
                            ->withErrors($validator);
        } else {
            $user = User::create([
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'password' => Hash::make($request->input('password')),
            ]);
            if ($request->input('role') == null) {
                DB::table('user_has_role_in_school')->insert(['user_id' => $user->id, 'school_id' => null, 'constant_id' => null]);
            } else {
                DB::table('user_has_role_in_school')->insert(['user_id' => $user->id, 'school_id' => session()->get('school_id'), 'constant_id' => $request->input('role')]);
            }
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
         $this->authorize('update', User::find($id));
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

    public function getMyWorkingSheet() {
        $login_user = auth()->user();
        $year = \Illuminate\Support\Carbon::now()->year;
        $month = \Illuminate\Support\Carbon::now()->month;
        $datas = collect();
        $isHeadMaster = $login_user->roles->contains(47);
        $isAdmin = $login_user->roles->contains(46);
        if ($isHeadMaster or $isAdmin) {
            $teachers = User::whereHas('roles', function (Builder $query) {
                        $query->where('constant_id', '=', 48);
                    })->get();
            foreach ($teachers as $teacher) {
                $this->getTeacherCourseStatistic($teacher, $year, $month) === null ?: $datas->push($this->getTeacherCourseStatistic($teacher, $year, $month));
            }
        } else {
            $datas->push($this->getTeacherCourseStatistic($login_user, $year, $month));
        }
        return view('user.working_sheet')->with('month', $month)->with('datas', $datas)->with('year', $year);
    }

    private function getTeacherCourseStatistic($user, $year, $month) {
        $data = collect();
        $sum_of_class = 0;
        $sum_of_student = 0;
        foreach ($this->getTCKClassByUserId($user->id) as $class) {
            $teachersData = DB::table('schedules')->join('classmodels', 'schedules.classmodel_id', 'classmodels.id')->join('courses', 'courses.id', 'classmodels.course_id')
                            ->where([['schedules.attend', '1'], ['classmodels.teacher_id', $user->id], ['courses.school_id', session()->get('school_id')], ['courses.deleted_at', null], ['classmodels.deleted_at', null], ['courses.is_speciality_course', '1'], ['classmodels.id', $class->id]])
                            ->whereYear('date', $year)->whereMonth('date', $month)->select('schedules.attend')->get();
            if ($teachersData->count() != 0) {//in case there is a class but no student was attended
                $count_of_attended = $teachersData->sum('attend');
                $sum_of_class++;
                $sum_of_student += $count_of_attended;
            }
        }
        $data->put('teacher', collect($user)->toArray());
        $data->put('sum_of_class', $sum_of_class);
        $data->put('sum_of_student', $sum_of_student);
        return $data->toArray();
    }

    private function getTCKCourseList() {
        $claz = DB::table('classmodels')->join('courses', 'classmodels.course_id', 'courses.id')
                        ->where([['courses.deleted_at', null], ['classmodels.deleted_at', null], ['courses.is_speciality_course', '1'], ['courses.school_id', session()->get('school_id')]])
                        ->select('classmodels.name', 'classmodels.teacher_id', 'classmodels.id')->get();
        return $claz;
    }

    private function getTCKWorkingSheet($user, $year, $month) {
        $attends = DB::table('schedule_student')->join('schedules', 'schedules.id', 'schedule_student.schedule_id')->join('classmodels', 'classmodels.id', 'schedules.classmodel_id')->join('courses', 'courses.id', 'classmodels.course_id')
                ->where([['classmodels.teacher_id', '=', $user->id], ['courses.course_category_id', '<>', 12], ['courses.deleted_at', '<>', null], ['classmodels.deleted_at', '<>', null]])->whereYear('schedules.date', $year)->whereMonth('schedules.date', $month)
                ->select('schedules.date', 'classmodels.id', 'schedule_student.student_id', 'schedule_student.attended')
                ->get();
        $totalClass = 0;
        $totalStudent = 0;
        foreach ($this->getCountOfClassByUserId($user->id) as $class) {
            foreach ($this->getScheduleByClassId($class->id, $year, $month) as $schedule) {
                $countofAttend = $attends->where([['id', $class->id], ['date', $schedule->date]])->all()->sum('attended');
                if ($countofAttend > 0) {
                    $totalClass++;
                    $totalStudent = $totalStudent + $countofAttend;
                }
            }
        }
        return ['user' => $user, 'totalClass' => $totalClass, 'totalStudent' => $totalStudent];
    }

    private function getTCKClassByUserId($user_id) {
        $claz = DB::table('classmodels')->join('courses', 'courses.id', 'classmodels.course_id')
                        ->where([['classmodels.teacher_id', '=', $user_id], ['courses.is_speciality_course', '1'], ['courses.deleted_at', null], ['classmodels.deleted_at', null], ['courses.school_id', session()->get('school_id')]])
                        ->select('classmodels.id')->get();
        return $claz;
    }

    function getScheduleByClassId($classmodel_id, $year, $month) {
        $schedules = DB::tables('schedules')->whereYear('schedules.date', $year)->whereMonth('schedules.date', $month)->where('classmodel_id', $classmodel_id)->get();
        return $schedules;
    }

    /*
     * get 特长课 list by user id, year, month
     */

    public function getTCKListByTeacherId(Request $request) {
        $claz = DB::table('classmodels')->join('courses', 'classmodels.course_id', 'courses.id')->join('schedules', 'schedules.classmodel_id', 'classmodels.id')
                        ->where([['courses.deleted_at', null], ['classmodels.deleted_at', null], ['courses.is_speciality_course', '1'], ['classmodels.teacher_id', $request->input('teacher_id')], ['courses.school_id', session()->get('school_id')]])
                        ->whereYear('schedules.date', $request->input('year'))->whereMonth('schedules.date', $request->input('month'))
                        ->select('classmodels.name', 'classmodels.id')->distinct()->get();
        return view('user.my_class_list')->with('classes', $claz);
    }

}

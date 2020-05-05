<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Schedule;
use App\Model\Specialdate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class ScheduleController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->authorizeResource(Schedule::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $date = request('date');
        session('date', $date);
        $student_id = session('student_id');
        $classmodel_id = session('classmodel_id');
        $class = \App\Model\Classmodel::find($classmodel_id); //class will always be found whoever request. 
        $schedules = $this->lazyInitSchedules($class, $date);
        return view('schedule.create', ['schedules' => $schedules, 'date' => $date, 'student_id' => $student_id]);
    }

    /*
     * to init schedules by class
     * 1. if class is null, means the request from a parent and her(his) kid does not belong to a class,which provide meals.
     * 2. if the class is not a null, the schedules will be inited by the class, loop through all students and create a schedule in case there is no recorder
     */

    private function lazyInitSchedules($class, $date) {
        if ($class === null) {
            return null;
        }
        $schedules = Schedule::where([['date', $date], ['classmodel_id', $class->id]])->get();
        $count_of_students = $class->students->count();
        if ($schedules->count() >= $count_of_students) {
            return $schedules;
        } else {
            foreach ($class->students as $student) {
                $schedules->where('student_id', $student->id)->count() === 0 ? $this->insertNewSchedule($date, $class->id, $student->id) : null;
            }
            $schedules = Schedule::where([['date', $date], ['classmodel_id', $class->id]])->get();
        }
        return $schedules;
    }

    /*
     * to insert a new schedule record by 
     */

    private function insertNewSchedule($date, $classmodel_id, $student_id) {
        $schedule = new Schedule;
        $schedule->date = $date;
        $schedule->classmodel_id = $classmodel_id;
        $schedule->student_id = $student_id;
        $schedule->save();
    }

    /*
     * the mothod is for booking meals of 托管 class, in order to simplify parent's operations, no need to select course before booking meal
     * get the first ongoing 托管class
     */

    private function getClassmodelByStudentId($student_id) {
        $classes = \App\Model\Student::find($student_id)->classmodels;
        $sortedClasses = $classes->sortByDesc('id');
        foreach ($sortedClasses as $class) {
            if ($class->course->is_speciality_course === '0') {
                session()->put('classmodel_id', $class->id); //find the class and save the class id to session.
                return $class;
            }
        }
        return null;
    }

    /*
     * to get schedule id in 2 cases:
     * 1. to get existing schedule id
     * 2. to create a new schedule and fetch the id
     */

    private function getSchedulesByClassIdAndDate($class_id, $date) {
        $schedules = DB::table('schedules')->where([
                    ['classmodel_id', '=', $class_id],
                    ['date', '=', $date],
                ])->get();
        // $schedule_student = collect([]);
        $schedule_id = -1;  // init schedule id;
        if ($schedules->count() == 1) {
            $schedule_id = $schedules->first()->id;
            // check if there is student join the class newly 
        }
        // there is no existing schedule, create a new schedule
        if ($schedules->count() == 0) {
            $schedule_id = $this->createNewSchedule($class_id, $date);
            //为每天都吃饭的学生报餐
            $this->autoBookMeal($schedule_id, $class_id);
        }
        return $schedule_id;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $schedule_id = $request->input('schedule_id');
        $field = $request->input('field');
        $value = $request->input('value') == 'true' ? 1 : 0;
        $schedule = Schedule::find($schedule_id);
        if ($field === 'attend' || $schedule->classmodel->course->is_speciality_course === 1) {
            $class_student = DB::table('course_student')->where([['school_id', session('school_id')], ['student_id', $schedule->student_id], ['classmodel_id', $schedule->classmodel_id]])->get()->first();
            $how_many_left = $class_student->how_many_left;
            if ($value > 0) {
                //如果值為1 則剩餘次數上-1
                $how_many_left--;
            } else {
                //如果值為0 則剩餘次數上+1
                $how_many_left++;
            }
            DB::table('course_student')
                    ->where('id', $class_student->id)
                    ->update(['how_many_left' => $how_many_left]);
        }
        $schedule->$field = $value;
        $schedule->save();
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

    public function getCalendarList(Request $request) {
        session()->put('classmodel_id', $request->input('classmodel_id')); //class id can be null, if the class id is not null and student id is null,which means the request is from teacher
        session()->put('student_id', $request->input('student_id')); //student can be null, if student id is not null and class id is null, which means the request is from parent
        return view('schedule.calendarList')->with('calendar', $this->getScheduleDates());
    }

    private function getScheduleDates() {
        $class = null;
        if (session('classmodel_id') === null) {
            $class = $this->getClassmodelByStudentId(session()->get('student_id'));
        } else {
            $class = \App\Model\Classmodel::find(session()->get('classmodel_id'));
        }
        return $this->formCalendarList($class);
    }

    private function formCalendarList($class) {
        $data = collect();
        $DATE_STRING_KEY = 'date';
        $SUBMITTABLE_STRING_KEY = 'submittable';
        if ($class == null) {
            return $data;
        }
        if ($class->course->is_speciality_course === '1') {
            foreach (json_decode($class->which_days) as $day) {
                if (now()->dayOfWeek === $day) {
                    $dateArray = Arr::add(Arr::add([], $DATE_STRING_KEY, now()->format('Y-m-d')), $SUBMITTABLE_STRING_KEY, $this->canDisplay(now()->format('Y-m-d'), $class));
                    $data->push($dateArray);
                }
            }
        } else {
            for ($i = 0; $i < 7; $i++) {
                $date = now()->addDays($i - (now()->dayOfWeek))->format('Y-m-d');
                $dateArray = Arr::add(Arr::add([], $DATE_STRING_KEY, $date), $SUBMITTABLE_STRING_KEY, $this->canDisplay($date, $class));
                $data->push($dateArray);
            }
        }
        return $data;
    }

    /*
     * 是否显示订餐考勤按钮，
     */

    private function canDisplay($theDate, $class) {
        $date = \Illuminate\Support\Carbon::make($theDate);
        $holidays = Specialdate::where('type', Specialdate::$HOLIDAY)->get();
        $workingdays = Specialdate::where('type', Specialdate::$WORKINGDAY)->get();

        //周6，周日，国家法定假日，课程的开始的第一天，课程结束的最后一天
        $classStart_date = \Illuminate\Support\Carbon::make($class->start_date)->format('Y-m-d');
        $ClassClosed_date = \Illuminate\Support\Carbon::make($class->end_date)->format('Y-m-d');
//        非托管的课程只显示当天，并且节假日都能打卡
        if ($class->course->is_speciality_course === '1') {
            return true;
        } else {
//        托管类的周日周六，国家法定节假日都不能打卡订餐
            if ($date->dayOfWeek === 6 or $date->dayOfWeek === 0 or $holidays->where('which_day', $theDate)->count() === 1 or $ClassClosed_date <= $date or $classStart_date >= $date) {
                if ($workingdays->where('which_day', $theDate)->count() === 0) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }
    }

    function getScheduleDetailByMonth(Request $request) {
        $classmodel_id = $request->input('classmodel_id');
        session()->put('classmodel_id', $classmodel_id);
        $classmodel = \App\Model\Classmodel::find($classmodel_id);
        $date = $request->input('date');
//        $student_id = $request->input('student_id');
        if ($date != null) {
            $date = \Illuminate\Support\Carbon::create($date);
        } else {
            $date = now()->setDay(1);
        }
        return $this->getScheduleDetailByClassAndDate($classmodel, $date);
    }

    private function getScheduleDetailByClassAndDate($classmodel, \Illuminate\Support\Carbon $date) {
        $schedules = Schedule::where('classmodel_id', $classmodel->id)->whereYear('date', $date->year)->whereMonth('date', $date->month)->get();
        $theDate = \Illuminate\Support\Carbon::create($date->format('Y-m-d'));
        $nextMonth = $theDate->addMonth()->month; //next month
        $theDate->subMonth(); //set the month back to current month
        $data = collect();
        while ($theDate->month < $nextMonth) {
            $data->push($theDate->format('Y-m-d'));
            $theDate->addDay();
        }
        return view('schedule.schedule_month_detail', ['schedules' => $schedules, 'date' => $date, 'class' => $classmodel, 'dates' => $data]);
    }

    function getLastMonthScheduleDetail(Request $request) {
        $date = $request->input('date');
        if ($date != null) {
            $date = \Illuminate\Support\Carbon::create($date)->subMonth();
            return $this->getScheduleDetailByClassAndDate(\App\Model\Classmodel::find(session()->get('classmodel_id')), $date);
        }
    }

    function getNextMonthScheduleDetail(Request $request) {
        $date = $request->input('date');
        if ($date != null) {
            $date = \Illuminate\Support\Carbon::create($date)->addMonth();
            return $this->getScheduleDetailByClassAndDate(\App\Model\Classmodel::find(session()->get('classmodel_id')), $date);
        }
    }
    
      /*
     * 打卡日期已经过了，超级管理员和管理员可以补打卡
     */
    public function reCheckIn(Request $request) {
        $this->authorize('$request');
        if (auth()->user()->hasanyrole('admin|superAdmin')) {
            $class_id = $request->input('class_id');
            $date = $request->input('date');
            $schedule_id = $this->getScheduleIdByClassIdAndDate($class_id, $date);
            $attendance = $this->getAttendanceData($schedule_id, null);
            return View::make('backend.schedule.create')->with('students', $attendance)->with('date', $date)->with('class_id', $class_id)->with('meal_flags', $this->getMealFlags($class_id))->with('exception', $this->getDinnerExceptions());
        } else {
            return '404';
        }
    }

}

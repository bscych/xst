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
        $this->autoBookMeal($classmodel_id,$date); //auto book meals
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

    private function getClassmodelByStudent($student) {
        $classes = $student->classmodels;
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

public function setAutoBookMeal(Request $request) {
        $student_id = $request->input('student_id');
        $class_id = $request->input('class_id');
        $auto_book_meal_singal = $request->input('auto_book_meal_singal');
        $which_meal = $request->input('which_meal');
        if($auto_book_meal_singal){
            $updateArr = [$which_meal=>$auto_book_meal_singal?1:0,'attended'=>1];
        }else{
            $updateArr = [$which_meal=>0];
        }
   
        DB::table('auto_book_meal_students')->updateOrInsert(
                ['student_id' => $student_id, 'class_id' => $class_id, 'school_id' => session('school_id')],
                $updateArr
        );
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

    /*
     * parent can book meals for their kids, parents can book meals only when their kids are taking 托管类型 course
     * 
     */

    public function parentBookMeals(Request $request) {
        $student = \App\Model\Student::find($request->input('student_id'));
        if ($student != null) {
            session()->put('student_id', $student->id);
        }
        $class = \App\Model\Classmodel::find($request->input('classmodel_id')); //get student's attending class
        if ($class != null) {
            session()->put('classmodel_id', $class->id);
        }
        $returnData = collect();
        $data = $this->formCalendarList($class);
        foreach ($data as $date) {
            $dDate = data_get($date, config()->get('constants.DATE_STRING_KEY'));
            $schedules = $this->lazyInitSchedules($class, $dDate);
            $schedule = $schedules->where('student_id', session('student_id'))->first();
            $dateColl = collect($date);
            $dateColl->put(config()->get('constants.SCHEDULE_STRING_KEY'), $schedule);
            $menu = \App\Model\Menu::where('which_day', $dDate)->where('school_id', session()->get('school_id'))->first();
            $dateColl->put(config()->get('constants.MENU_STRING_KEY'), $menu);
            $dateColl->put(config()->get('constants.CAN_DISPLAY_STRING_KEY'), $this->canDisplay($dDate, $class));
            $dateColl->put(config()->get('constants.CAN_EDIT_STRING_KEY'), $this->canEditByDateTime($dDate));
            $returnData->push($dateColl);
        }
        $autoBookMeal = DB::table('auto_book_meal_students')->where('school_id', session('school_id'))->where('student_id', session('student_id'))->where('class_id', session('classmodel_id'))->first();
        return view('schedule.create_parent', ['schedules' => $returnData, 'student' => $student, 'class' => $class,'auto_book_meal'=>$autoBookMeal]);
    }

    public function getCalendarList(Request $request) {
        session()->put('classmodel_id', $request->input('classmodel_id')); //class id can be null, if the class id is not null and student id is null,which means the request is from teacher
        session()->put('student_id', $request->input('student_id')); //student can be null, if student id is not null and class id is null, which means the request is from parent
        return view('schedule.calendarList')->with('calendar', $this->getScheduleDates());
    }

    private function getScheduleDates() {
        $class = null;
        if (session('classmodel_id') === null) {
            $class = $this->getClassmodelByStudent(\App\Model\Student::find(session()->get('student_id')));
        } else {
            $class = \App\Model\Classmodel::find(session()->get('classmodel_id'));
        }
        return $this->formCalendarList($class);
    }

    private function formCalendarList($class) {
        $data = collect();
        if ($class == null) {
            return $data;
        }
        if ($class->course->is_speciality_course === 1) {
            foreach (json_decode($class->which_days) as $day) {
                if (now()->dayOfWeek === data_get($day, 'day')) {
                    $dateArray = Arr::add(Arr::add([], config()->get('constants.DATE_STRING_KEY'), now()->format('Y-m-d')), config()->get('constants.SUBMITTABLE_STRING_KEY'), $this->canDisplay(now()->format('Y-m-d'), $class));
                    $data->push($dateArray);
                }
            }
        } else {
            for ($i = 0; $i < 7; $i++) {
                $date = now()->addDays($i - (now()->dayOfWeek))->format('Y-m-d');
                $dateArray = Arr::add(Arr::add([], config()->get('constants.DATE_STRING_KEY'), $date), config()->get('constants.SUBMITTABLE_STRING_KEY'), $this->canDisplay($date, $class));
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
        $holidays = Specialdate::where('type', Specialdate::$HOLIDAY)->where('school_id', session()->get('school_id'))->get();
        $workingdays = Specialdate::where('type', Specialdate::$WORKINGDAY)->where('school_id', session()->get('school_id'))->get();
        //周6，周日，国家法定假日，课程的开始的第一天，课程结束的最后一天
        $classStart_date = \Illuminate\Support\Carbon::make($class->start_date)->format('Y-m-d');
        if ($class->end_date === null) {
            $ClassClosed_date = null;
        } else {
            $ClassClosed_date = \Illuminate\Support\Carbon::make($class->end_date)->format('Y-m-d');
        }
        if ($class->course->is_speciality_course === 1) {//非托管的课程只显示当天，并且节假日都能打卡
            return true;
        }
        if ($ClassClosed_date < $date or $ClassClosed_date === null) {//超过课程结束日期， 不能点餐，签到
            return false;
        }
        if ($classStart_date > $date) {//不到课程开始日期，不能点餐，签到
            return false;
        }
        if (($date->dayOfWeek === 6 or $date->dayOfWeek === 0 or $holidays->where('which_day', $theDate)->count() === 1) and $class->course->is_speciality_course === 0 ) { // 托管类的周日周六，国家法定节假日都不能打卡订餐  
            if ($workingdays->where('which_day', $theDate)->count() === 0) {
                return false;
            } else {
                return true;
            }
        } else {
            //    如果选择特定的哪一天托管，那么检查which_days是否为空
                    $whichDays = collect(json_decode($class->which_days));
                    if ($whichDays->isEmpty()) {
                        // 如果每周正常托管，class的上课频率一周内每天都没勾选，就返回true
                        return true;
                    } else {
//              which_days不为空则说明，特定某天托管，只允许订当天的餐
                        foreach($whichDays as $whichDay){
                            if($whichDay->day===$date->dayOfWeek){
                                return true;
                            }
                        }
                        return false;
                    }
        }
    }

    private function canEditByDateTime($date) {
        $currentDate = date('Y-m-d', time());
        //比当天晚的餐，可以
        if ($date > $currentDate) {
            return true;
        }
        //今天的餐，家长9点前可以，9点后不可以，老师今天都可以
        if ($date == $currentDate) {
            if (\Illuminate\Support\Carbon::now()->greaterThan(\Illuminate\Support\Carbon::createFromTime(9, 0, 0))) {
                return false;
            }
            return true;
        }
        //比今天晚的餐，只能查看，不能编辑
        return false;
    }

    function getScheduleDetailByMonth(Request $request) {
        $student_id = $request->input('student_id');
        $student = null;
        if ($student_id != null) {
            session()->put('student_id', $student_id);
            $student = \App\Model\Student::find($student_id);
        }
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
        return $this->getScheduleDetailByClassAndDate($classmodel, $student, $date);
    }

    private function getScheduleDetailByClassAndDate($classmodel, $student, \Illuminate\Support\Carbon $date) {
        $students = null;
        if ($student != null) {
            $schedules = Schedule::where([['classmodel_id', $classmodel->id], ['student_id', $student->id]])->whereYear('date', $date->year)->whereMonth('date', $date->month)->get();
            $students = collect($classmodel->students->where('id', $student->id)->all());
        } else {
            $schedules = Schedule::where('classmodel_id', $classmodel->id)->whereYear('date', $date->year)->whereMonth('date', $date->month)->get();
            $students = $classmodel->students;
        }
        $theDate = \Illuminate\Support\Carbon::create($date->format('Y-m-d'));
        $nextMonth = $theDate->addMonth()->month; //next month
        $theDate->subMonth(); //set the month back to current month
        $data = collect();
        while ($theDate->month < $nextMonth) {
            $data->push($theDate->format('Y-m-d'));
            $theDate->addDay();
        }
        return view('schedule.schedule_month_detail', ['schedules' => $schedules, 'date' => $date, 'students' => $students, 'dates' => $data, 'class' => $classmodel]);
    }

    function getLastMonthScheduleDetail(Request $request) {
        $date = $request->input('date');
        if ($date != null) {
            $date = \Illuminate\Support\Carbon::create($date)->subMonth();
            $clasmodel = \App\Model\Classmodel::find(session()->get('classmodel_id'));
            $student = \App\Model\Student::find(session()->get('student_id'));
            return $this->getScheduleDetailByClassAndDate($clasmodel, $student, $date);
        }
    }

    function getNextMonthScheduleDetail(Request $request) {
        $date = $request->input('date');
        if ($date != null) {
            $date = \Illuminate\Support\Carbon::create($date)->addMonth();
            $clasmodel = \App\Model\Classmodel::find(session()->get('classmodel_id'));
            $student = \App\Model\Student::find(session()->get('student_id'));
            return $this->getScheduleDetailByClassAndDate($clasmodel, $student, $date);
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
    
     function autoBookMeal($class_id,$date) {
        $students = DB::table('auto_book_meal_students')
                ->where('class_id', $class_id)
                ->get();
        if ($students->count() > 0) {
            foreach ($students as $student) {
                DB::table('schedules')                      
                        ->where('student_id', $student->student_id)
                        ->where('classmodel_id',$class_id)
                        ->where('date',$date)
                        ->update(['attend' => $student->attended, 'lunch' => $student->lunch, 'dinner' => $student->dinner]);
            }
        }
    }

}

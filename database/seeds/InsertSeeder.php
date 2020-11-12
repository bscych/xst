<?php

use Illuminate\Database\Seeder;

class InsertSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->insertSchool();
        $this->insertConstants();
        $this->insertIntoUser_has_role_in_school();
        $this->insertSchool_Student();
        $this->insertSchedule();
        $this->insertConstant_School();
    }

    private function insertSchool() {
        DB::table('schools')->insert(
                ['id' => 1, 'name' => '大连小书童教育中心', 'lunch_fee' => 15, 'dinner_fee' => 15, 'snack_fee' => 5, 'threshold' => 3]);
        DB::table('schools')->insert(
                ['id' => 0, 'name' => '普瑞教育']);
        DB::table('schools')->where('id', 2)->update(['id' => 0]);
    }

    private function insertConstant_School() {
        $schools = DB::table('students')->select('constant_school_id')->distinct()->get();
        foreach ($schools as $school) {
            DB::table('constants')->insert(['parent_id' => 44, 'name' => 'school', 'label_name' => $school->constant_school_id, 'school_id' => 1, 'created_at' => now()]);
        }
    }

    private function insertSchedule() {
        $schedules = DB::table('schedule_student')->join('schedules', 'schedules.id', 'schedule_student.schedule_id')->select('schedules.classmodel_id', 'schedule_student.student_id', 'schedules.date', 'schedule_student.attended', 'schedule_student.lunch', 'schedule_student.dinner')->get();
        $attendance_data = collect();
        $mealbooking_data = collect();
        foreach ($schedules as $schedule) {
            $attenance = collect();
            $mealbooking = collect();
            $attenance->put('school_id', 1);
            $attenance->put('class_id', $schedule->classmodel_id);
            $attenance->put('student_id', $schedule->student_id);
            $attenance->put('date', $schedule->date);
            $attenance->put('attend', $schedule->attended);
            if( $schedule->attended==='1'){
                 $attendance_data->push($attenance);
            }            
            $mealbooking->put('school_id', 1);
            $mealbooking->put('student_id', $schedule->student_id);
            $mealbooking->put('date', $schedule->date);
            $mealbooking->put('lunch', $schedule->lunch);
            $mealbooking->put('dinner', $schedule->dinner);
            if( $schedule->lunch==='1' or $schedule->dinner==='1'){
                $mealbooking_data->push($mealbooking);
            }
        }
        DB::table('attendances')->insert($attendance_data->toArray());
        DB::table('mealbookings')->insert($mealbooking_data->toArray());
    }

    private function insertSchool_Student() {
        $data = collect();
        foreach (\App\Model\Student::all() as $student) {
            $d = collect();
            $d->put('school_id', 1);
            $d->put('student_id', $student->id);
            $data->push($d);
        }
        DB::table('school_student')->insert($data->toArray());
    }

    private function insertIntoUser_has_role_in_school() {
        $user_has_roles = DB::table('model_has_roles')->get();
        $data = collect();
        foreach ($user_has_roles as $user_has_role) {
            $d = collect();
            $d->put('constant_id', $this->findConstant_id($user_has_role->role_id));
            $d->put('user_id', $user_has_role->model_id);
            $d->put('school_id', 1);
            $data->push($d);
        }
        DB::table('user_has_role_in_school')->insert($data->toArray());
    }

    private function findConstant_id($role_id) {
        if ($role_id === 1) {//admin,headmaster
            return App\Model\Constant::where('name', 'headmaster')->first()->id;
        }
        if ($role_id === 2) {//teacher
            return App\Model\Constant::where('name', 'teacher')->first()->id;
        }
        if ($role_id === 3) {//superAdmin
            return App\Model\Constant::where('name', 'admin')->first()->id;
        }
        if ($role_id === 4) {//supervisor
            return App\Model\Constant::where('name', 'supervisor')->first()->id;
        }
        if ($role_id === 5) {//parent
            return App\Model\Constant::where('name', 'parent')->first()->id;
        }
        if ($role_id === 6) {//cook
            return App\Model\Constant::where('name', 'cook')->first()->id;
        }
    }

    private function insertConstants() {
        DB::table('constants')->where('id', 46)
                ->update(['parent_id' => 5, 'name' => 'admin', 'label_name' => '管理员']);
        DB::table('constants')->insert([
//            ['parent_id' => 5, 'name' => 'admin', 'label_name' => ' 管理员'], //replace school to constant
            ['parent_id' => 5, 'name' => 'headmaster', 'label_name' => ' 校长'],
            ['parent_id' => 5, 'name' => 'teacher', 'label_name' => ' 老师'],
            ['parent_id' => 5, 'name' => 'supervisor', 'label_name' => ' 教学主管'],
            ['parent_id' => 5, 'name' => 'parent', 'label_name' => ' 父母'],
            ['parent_id' => 5, 'name' => 'cook', 'label_name' => ' 厨房'],
            ['parent_id' => 5, 'name' => 'student', 'label_name' => ' 学员'],
            ['parent_id' => 4, 'name' => 'another', 'label_name' => ' 其他'],
            ['parent_id' => 4, 'name' => 'rental', 'label_name' => ' 房租']
        ]);
    }

}

<?php

use Illuminate\Database\Seeder;

class UpdateSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
//        DB::table('schools')->insert(
//                ['id' => 1, 'name' => '大连小书童教育中心', 'lunch_fee' => 15, 'dinner_fee' => 15, 'snack_fee' => 5, 'threshold' => 3]);
//        DB::table('schools')->insert(
//                ['id' => 0, 'name' => '普瑞教育']);
//        DB::table('schools')->where('id', 2)->update(['id' => 0]);
//        $this->updateConstant();
//        $this->insertConstants();
//        $this->updateCourse();
//        $this->updateClass();
//        $this->updateCourseStudent();
//        $this->updateEnroll();
//        $this->updateIncome();
//        $this->updateMenu();
//        $this->updateSpecialDate();
//        $this->updateHomework();
//        $this->insertIntoUser_has_role_in_school();
//        $this->insertSchool_Student();
//        $this->updateSpend();
//        $this->updatUser_has_role_in_school();
//        $this->insertSchool_Student();
//        $this->insertSchedule();
//        $this->insertConstant_School();
//        $this->updateStudent_school();
//        $this->updateMenuItems();
    }
    
    private function insertConstant_School() {
        $schools = DB::table('students')->select('school')->distinct()->get();
        foreach ($schools as $school){
            DB::table('constants')->insert(['parent_id' => 44, 'name' => 'school','label_name'=>$school->school,'school_id'=>1,'created_at'=> now()] );
        }
    }
    
      private function updateStudent_school() {
         DB::table('students')->where('school', '橡树学校')->update(['school' => App\Model\Constant::where('label_name','橡树学校')->first()->id]);
         DB::table('students')->where('school', '普罗旺斯一期幼儿园')->update(['school' => App\Model\Constant::where('label_name','普罗旺斯一期幼儿园')->first()->id]);
         DB::table('students')->where('school', '普罗旺斯二期幼儿园')->update(['school' => App\Model\Constant::where('label_name','普罗旺斯二期幼儿园')->first()->id]);
         DB::table('students')->where('school', '高新园区中心小学')->update(['school' => App\Model\Constant::where('label_name','高新园区中心小学')->first()->id]);
         DB::table('students')->where('school', '普罗旺斯小学')->update(['school' => App\Model\Constant::where('label_name','普罗旺斯小学')->first()->id]); //data has  beeen inserted
    }

    private function insertSchedule() {
        $schedules = DB::table('schedule_student')->join('schedules','schedules.id','schedule_student.schedule_id')->select('schedules.classmodel_id', 'schedule_student.student_id', 'schedules.date', 'schedule_student.attended', 'schedule_student.lunch', 'schedule_student.dinner')->get();
        $data = collect();
        foreach ($schedules as $schedule) {
            $d = collect();
            $d->put('classmodel_id', $schedule->classmodel_id);
            $d->put('student_id', $schedule->student_id);
            $d->put('date', $schedule->date);
            $d->put('attend', $schedule->attended);
            $d->put('lunch', $schedule->lunch);
            $d->put('dinner', $schedule->dinner);
            $data->push($d);
        }
          DB::table('schedules')->delete();
          DB::table('schedules')->insert($data->toArray());
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
            return App\Model\Constant::where('name','headmaster')->first()->id;
        }
        if ($role_id === 2) {//teacher
            return App\Model\Constant::where('name','teacher')->first()->id;
        }
        if ($role_id === 3) {//superAdmin
            return App\Model\Constant::where('name','admin')->first()->id;
        }
        if ($role_id === 4) {//supervisor
            return App\Model\Constant::where('name','supervisor')->first()->id;
        }
        if ($role_id === 5) {//parent
            return App\Model\Constant::where('name','parent')->first()->id;
        }
        if ($role_id === 6) {//cook
            return App\Model\Constant::where('name','cook')->first()->id;
        }
    }

    private function updatUser_has_role_in_school() {
        DB::table('user_has_role_in_school')->where('id', 18)->update(['school_id' => 0]);
    }

    private function updateSpend() {
        DB::table('spends')->where('school_id', 0)->update(['school_id' => 1]);
    }

    private function updateMenu() {
        DB::table('menus')->where('school_id', 0)->update(['school_id' => 1]);
    }

    private function updateIncome() {
        DB::table('incomes')->where('school_id', 0)->update(['school_id' => 1]);
    }

    private function updateEnroll() {
        DB::table('enrolls')->where('school_id', 0)->update(['school_id' => 1]);
    }

    private function updateCourseStudent() {
        DB::table('course_student')->where('school_id', 0)->update(['school_id' => 1]);
    }

    private function updateCourse() {
        DB::table('courses')->where('school_id', 0)->update(['school_id' => 1]);
       foreach(\App\Model\Course::all() as $course){
           if($course->name->contains('托管') or ($course->name->contains('幼小'))){
               
           }else{
             DB::table('courses')->update(['is_speciality_course'=>1]);
           }
       }
    }
    
     private function updateClass() {
        foreach(App\Model\Classmodel::all() as $clas){
            $days = collect();
            foreach(json_decode($clas->which_days) as $day){
                 $dayArr = ['day'=>$day,'time'=>['start_at'=>null,'end_at'=>null]]; 
                 $days->push($dayArr);
             }
             $clas->which_days = $days->toJson();
             $clas->save();
        }    
    }
    
      private function updateSpecialDate() {
        DB::table('specialdates')->where('school_id', 0)->update(['school_id' => 1]);
    }
     private function updateHomework() {
        DB::table('homeworks')->where('school_id', 0)->update(['school_id' => 1]);
    }
     private function updateMenuItems() {
        DB::table('menuitems')->where('school_id', 0)->update(['school_id' => 1]);
    }

    private function insertConstants() {
         DB::table('constants')->where('id', 46)
                ->update(['parent_id' => 5,'name' => 'admin', 'label_name' => '管理员']);
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

    private function updateConstant() {
        DB::table('constants')->where('id', 44)->update(['name' => 'school', 'label_name' => '周边学校名称']);
        DB::table('constants')->where('id', 1)->update(['name' => 'how_to_pay', 'label_name' => '支付方式']);
        DB::table('constants')->where('id', 2)->update(['name' => 'course_categories', 'label_name' => '课程类型']);
        DB::table('constants')->where('id', 3)->update(['name' => 'expense_account', 'label_name' => '支出会计科目']);
        DB::table('constants')->where('id', 4)->update(['name' => 'revenue_account', 'label_name' => '收入会计科目']);
        DB::table('constants')->where('id', 5)->update(['name' => 'role', 'label_name' => '角色']);
        DB::table('constants')->where('id', 6)->update(['name' => 'refund_category', 'label_name' => '退费方式']);
        DB::table('constants')->where('id', 8)->update(['name' => 'POS', 'label_name' => 'POS']);
        DB::table('constants')->where('id', 9)->update(['name' => 'wechat', 'label_name' => '微信']);
        DB::table('constants')->where('id', 10)->update(['name' => 'ali_pay', 'label_name' => '支付宝']);
        DB::table('constants')->where('id', 11)->update(['name' => 'cash', 'label_name' => '现金']);
        DB::table('constants')->where('id', 17)->update(['name' => 'bank', 'label_name' => '银行转账']);
        DB::table('constants')->where('id', 18)->update(['name' => 'distribution', 'label_name' => '配送食材']);
        DB::table('constants')->where('id', 19)->update(['name' => 'non_distribution', 'label_name' => '非配送食材']);
        DB::table('constants')->where('id', 20)->update(['name' => 'snack', 'label_name' => '幼小衔接间点']);
        DB::table('constants')->where('id', 21)->update(['name' => 'tools', 'label_name' => '教具']);
        DB::table('constants')->where('id', 22)->update(['name' => 'decoration', 'label_name' => '装修']);
        DB::table('constants')->where('id', 23)->update(['name' => 'daily_necessities', 'label_name' => '日用品']);
        DB::table('constants')->where('id', 24)->update(['name' => 'training_fee', 'label_name' => '培训费']);
        DB::table('constants')->where('id', 25)->update(['name' => 'other', 'label_name' => '其他']);
        DB::table('constants')->where('id', 26)->update(['name' => 'salary', 'label_name' => '员工工资']);
        DB::table('constants')->where('id', 27)->update(['name' => 'class_fee', 'label_name' => '外聘老师课时费']);
        DB::table('constants')->where('id', 28)->update(['name' => 'tuoguan_fee', 'label_name' => '托管费']);
        DB::table('constants')->where('id', 29)
                ->update(['name' => 'speciality_course_fee', 'label_name' => '特长课交费']);
        DB::table('constants')->where('id', 30)
                ->update(['name' => 'meal_fee', 'label_name' => '餐费交费']);
        DB::table('constants')->where('id', 31)
                ->update(['name' => 'pre_fee', 'label_name' => '预交费']);
        DB::table('constants')->where('id', 32)
                ->update(['name' => 'refund', 'label_name' => '退费']);
        DB::table('constants')->where('id', 34)
                ->update(['name' => 'refund_cash', 'label_name' => '返现']);
        DB::table('constants')->where('id', 35)
                ->update(['name' => 'return_to_account', 'label_name' => '返回到帐户']);
        DB::table('constants')->where('id', 36)
                ->update(['name' => 'general_fee', 'label_name' => '杂费']);
        DB::table('constants')->where('id', 37)
                ->update(['name' => 'transportation_fee', 'label_name' => '车费']);
        DB::table('constants')->where('id', 43)
                ->update(['name' => 'account_balance', 'label_name' => '学生账户余额']);
        
        
    }
    

}

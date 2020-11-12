<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UpdateSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->updateConstant();
        $this->updateCourse();
        $this->updateCourseStudent();
        $this->updateEnroll();
        $this->updateIncome();
        $this->updateMenu();
        $this->updateSpecialDate();
        $this->updateHomework();
        $this->updateSpend();
        $this->updatUser_has_role_in_school();
        $this->updateStudent_school();
        $this->updateMenuItems();
    }

    private function updateStudent_school() {
        DB::table('students')->where('constant_school_id', '橡树学校')->update(['constant_school_id' => App\Model\Constant::where('label_name', '橡树学校')->first()->id]);
        DB::table('students')->where('constant_school_id', '普罗旺斯一期幼儿园')->update(['constant_school_id' => App\Model\Constant::where('label_name', '普罗旺斯一期幼儿园')->first()->id]);
        DB::table('students')->where('constant_school_id', '普罗旺斯二期幼儿园')->update(['constant_school_id' => App\Model\Constant::where('label_name', '普罗旺斯二期幼儿园')->first()->id]);
        DB::table('students')->where('constant_school_id', '高新园区中心小学')->update(['constant_school_id' => App\Model\Constant::where('label_name', '高新园区中心小学')->first()->id]);
        DB::table('students')->where('constant_school_id', '普罗旺斯小学')->update(['constant_school_id' => App\Model\Constant::where('label_name', '普罗旺斯小学')->first()->id]); //data has  beeen inserted
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
        foreach (\App\Model\Course::all() as $course) {
            if (Str::contains($course->name, '托管') or Str::contains($course->name, '幼小')) {
                DB::table('courses')->update(['is_speciality_course' => 0]);
            } else {
                DB::table('courses')->update(['is_speciality_course' => 1]);
            }
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Constant;

class FinanceController extends Controller {

    public function monthList() {
        $start_year = $this->getStartYear();
        $income = DB::table('incomes')->where([['finance_year', '>=', $start_year], ['school_id', session('school_id')]])->get()->sum('amount');
        $spend = DB::table('spends')->where([['finance_year', '>=', $start_year], ['school_id', session('school_id')]])->get()->sum('amount');
        return view('finance.index', ['start_year' => $start_year, 'incomes' => $income, 'spends' => $spend]);
    }

    public function detail(Request $request) {
        $year = $request->input('year');
        $month = $request->input('month');
        $date = now()->setDate($year, $month, 1);
        $spends = \App\Model\Spend::where([['school_id', session()->get('school_id')], ['finance_year', $date->year], ['finance_month', $date->month]])->get();
        $spendCategories = Constant::where('parent_id', 3)->get();
        $incomes = \App\Model\Income::where([['school_id', session()->get('school_id')], ['finance_year', $date->year], ['finance_month', $date->month]])->get();
        $incomeCatogories = Constant::where('parent_id', 4)->get();
//        $totalEnroll = \App\Model\Enroll::where([['created_at', $year],['created_at', $month],['school_id', session('school_id')]])->orderBy('created_at', 'desc')->get()->sum('paid');
//        $totalRemain = \App\Model\Student::where('balance', '>', 0)->get()->sum('balance');
        $mealsByMonth = DB::table('schedules')->join('school_student', 'schedules.student_id', 'school_student.student_id')->where('school_student.school_id', session('school_id'))->whereYear('date',$year)->whereMonth('date',$month)->get();
        return view('finance.detail')
                        ->with('spendCategories', $spendCategories)->with('incomes', $incomes)->with('spends', $spends)->with('incomeCategories', $incomeCatogories)->with('parameters', $date->year . '/' . $date->month)->with('lunch', $mealsByMonth->sum('lunch'))->with('dinner', $mealsByMonth->sum('dinner'));
    }

    private function getStartYear() {
        $school_id = session()->get('school_id');
        $income_year = DB::table('incomes')->select('finance_year')->where('school_id', $school_id)->distinct()->orderBy('finance_year', 'asc')->first();
        if ($income_year === null) {
            $income_year = now()->year;
        }else{
            $income_year = $income_year->finance_year;
        }
        $spend_year = DB::table('spends')->select('finance_year')->where('school_id', $school_id)->distinct()->orderBy('finance_year', 'asc')->first();
        if ($spend_year === null) {
            $spend_year = now()->year;
        }else{
            $spend_year = $spend_year->finance_year;
        }
        if ($spend_year > $income_year) {
            return $income_year;
        } else {
            return $spend_year;
        }
    }

}

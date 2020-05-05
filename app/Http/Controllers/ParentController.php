<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SchoolController;

class ParentController extends Controller {

    public function __construct(SchoolController $schoolController) {
        $this->middleware('auth');
        $this->schoolController = $schoolController;
    }

    protected $schoolController;

    public function swtich($school_id) {
        $this->schoolController->switch($school_id);
    }

    public function toBookMeal() {
        $user = auth()->user();
        if($user->myKids->count()===1){
            return redirect(route('schedule.getCalendarList',['student_id'=>$user->myKids->first()->id]));
        }
        if(auth()->user()->myKids->count()>1){
            return $this->kidList(auth()->user()->myKids);
        }        
    }
    
    public function kidList($kidList) {
        return view('parent.kidList',['kids'=>$kidList]);
    }
}

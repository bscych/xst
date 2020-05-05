<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;

class Selector extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
         $schools = DB::table('schools')
                ->join('user_has_role_in_school','schools.id','user_has_role_in_school.school_id')
                ->where('user_has_role_in_school.user_id', auth()->id())
                 ->whereIn('user_has_role_in_school.constant_id',[46,47,49])
                ->select('schools.id','schools.name')->get();
        return view('components.selector',['schools'=>$schools]);
    }
}

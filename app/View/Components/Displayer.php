<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;

class Displayer extends Component {

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        if (session()->get('school_id') === null) {
            $school = DB::table('schools')
                            ->join('user_has_role_in_school', 'schools.id', 'user_has_role_in_school.school_id')
                            ->where('user_has_role_in_school.user_id', auth()->id())
                            ->select('schools.id', 'schools.name')->first();
            session()->put('school_id', $school->id);
        }else{
            $school = \App\Model\School::find(session()->get('school_id'));
        }

        return view('components.displayer', ['school' => $school]);
    }

}

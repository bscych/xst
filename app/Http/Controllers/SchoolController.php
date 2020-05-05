<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Model\School;

class SchoolController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->authorizeResource(School::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $school_id_current = $request->input('school_id');
        session()->put('school_id', $school_id_current);
        $schools = \App\Model\School::where('parent_id',$school_id_current)->get();
        return view('school.index')->with('schools', $schools);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
//        $users = User::whereNotIn('id', function ($query) {
//                    $query->select('user_id')->from('user_has_role_in_school');
//                })->get();
        $users = User::all();
        return view('school.create')->with('users', $users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $rules = array('name' => 'required|string|max:255','headmaster_id' => 'required');
        $validator = Validator::make($request->all(), $rules);
        // process the login
        if ($validator->fails()) {
            return Redirect::to('school/create' . $request->input('id'))
                            ->withErrors($validator);
        } else {
            $school = new School;
            $school->parent_id = session('school_id');
            $school->name = $request->input('name');
            $school->phone = $request->input('phone');
            $school->address = $request->input('address');
            $school->lunch_fee = $request->input('lunch_fee');
            $school->dinner_fee = $request->input('dinner_fee');
            $school->snack_fee = $request->input('snack_fee');
            $school->threshold = $request->input('threshold');            
            $school->save();//insert a new school
            $headmaster_id = $request->input('headmaster_id');//fetch user id
            DB::table('user_has_role_in_school')->insert(['user_id' => $headmaster_id, 'school_id' => $school->id, 'constant_id' => \App\Model\Constant::where('name', 'headmaster')->first()->id]);//insert a record in user has role table
            return redirect('/school?school_id='. session('school_id'));
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
    
    public function switch($school_id) {
        if($school_id!=null){
            session()->put('school_id', $school_id);
            return redirect('/home');
        }
    }

}

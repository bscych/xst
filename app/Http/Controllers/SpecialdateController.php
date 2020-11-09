<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Specialdate;
class SpecialdateController extends Controller
{
    
    public function __construct() {
        $this->middleware('auth');
        $this->authorizeResource(Specialdate::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return view('specialdate.index')->with('dates', Specialdate::where('school_id', session()->get('school_id'))->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('specialdate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $rules = array(
            'name' => 'required',
            'which_day'=>'required',
        );
        $validator = validator(request()->all(), $rules);
        // process the login
        if ($validator->fails()) {
            return redirect('holiday/create')
                            ->withErrors($validator);
            
        } else {         
            $specialdate = new Specialdate;
            $specialdate->name = $request->input('name');
            $specialdate->type = $request->input('type');
            $specialdate->which_day = $request->input('which_day');
            $specialdate->school_id = session()->get('school_id');
            $specialdate->save();
            return $this->index();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

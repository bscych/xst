<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Constant;

class ConstantController extends Controller
{
    
    public function __construct() {
        $this->middleware('auth');
        $this->authorizeResource(Constant::class);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $this->authorize('viewAny', Constant::class);
        return view('constant.index')->with('constants',Constant::where('parent_id','=',$request->input('id'))->get())->with('id',$request->input('id'));        
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('constant.create')->with('id',$request->input('id'));
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
            'name' => 'required|string|max:255',
             'label_name'=>'required'
        );
        $validator = validator($request->all(), $rules);
        // process the login
        if ($validator->fails()) {
            return redirect('constant/create?id='.$request->input('id'))
                            ->withErrors($validator);            
        } else {         
            $constant = new Constant;
            $constant->name = $request->input('name');
            $constant->parent_id =  $request->input('parent_id');
            $constant->label_name = $request->input('label_name');
            $constant->save();          
            return redirect('constant?id='.$request->input('parent_id'));
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

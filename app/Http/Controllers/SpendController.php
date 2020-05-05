<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Spend;
use App\Model\Constant;

class SpendController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->authorizeResource(Spend::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $spends = Spend::where('school_id', session()->get('school_id'))->paginate(10);        
        return view('spend.index')->with('spends', $spends);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
       return view('spend.create') ->with('name_of_accounts', Constant::where('parent_id', 3)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $rules = array(
            'name' => 'required',
            'name_of_account' => 'required',
            'amount' => 'required|numeric|min:0',          
            'finance_year' => 'required',
            'finance_month' => 'required'
        );
        $validator = validator($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('spend/create')->withErrors($validator);
        } else {
            $spend = new Spend;
            $spend->name = $request->input('name');
            $spend->name_of_account = $request->input('name_of_account');
            $spend->amount = $request->input('amount');
            $spend->payment_method = $request->input('payment_method')==null?'微信':$request->input('payment_method');
            $spend->which_day = $request->input('which_day')==null?date("Y-m-d", time()):$request->input('which_day');
            $spend->finance_year = $request->input('finance_year');
            $spend->finance_month = $request->input('finance_month');
            $spend->comment = $request->input('comment');
            $spend->operator = auth()->id();
            $spend->school_id = session()->get('school_id');
            $spend->save();
            return $this->index();
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

}

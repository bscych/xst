<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Event;

class EventController extends Controller
{
    
    public function __construct() {
        $this->middleware('auth');
        $this->authorizeResource(Event::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('event.index')->with('events',Event::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('event.create');
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
            'start_date'=>'required|date',
            'end_date'=>'required|date|after:start_date',
        );
        $validator = validator(request()->all(), $rules);
        // process the login
        if ($validator->fails()) {
            return redirect('event/create')
                            ->withErrors($validator);
            
        } else {         
            $event = new Event;
            $event->name = $request->input('name');
            $event->start_date = $request->input('start_date');
            $event->end_date = $request->input('end_date');
            $event->save();
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

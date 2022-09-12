<?php

namespace App\Http\Controllers;
use App\Services\User\UserService;
use App\Fee;

use Illuminate\Http\Request;

class FeeController extends Controller
{
    protected $userService; 
    protected $fee; 

    public function __construct(UserService $userService,Fee $fee ){
        $this->userService = $userService; 
        $this->fee = $fee; 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $fees = \App\Fee::bySchool(\Auth::user()->school_id)->get();
      return view('fees.all',['fees'=>$fees]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $students = $this->userService->getAllStudents();
        return view('fees.create',['students'=>$students]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'fee_name' => 'required|string|max:255',
            'balance' => 'required|numeric'
        ]);
        $fee = new \App\Fee;
        $fee->fee_name = $request->fee_name;
        $fee->balance = $request->balance;
        $fee->school_id = \Auth::user()->school_id;
        $fee->user_id = \Auth::user()->id;
        $fee->save();
        return back()->with('status', __('Saved'));
    }

    public function balanceList(){ 
        $fees = $this->fee->with(['payment'])->get();
        return view('stripe.balance-list',['fees'=>$fees]);
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

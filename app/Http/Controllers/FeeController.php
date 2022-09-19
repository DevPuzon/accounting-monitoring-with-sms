<?php

namespace App\Http\Controllers;
use App\Services\User\UserService;
use App\Imports\FeesImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Fee;
use App\Payment;

use Illuminate\Http\Request;

class FeeController extends Controller
{
    protected $userService; 
    protected $fee; 
    protected $payment; 

    public function __construct(UserService $userService,Fee $fee,Payment $payment ){
        $this->userService = $userService; 
        $this->fee = $fee; 
        $this->payment = $payment; 
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
        $fee->user_id = $request->student_id;
        $fee->school_id = \Auth::user()->school_id;
        $fee->save();
        return back()->with('status', __('Saved'));
    }

    public function balanceList(){ 
        $fees = $this->fee
                ->with(['payment' ])   
                ->where('user_id',\Auth::user()->id)
                ->orWhere('user_id',0)
                ->get();
        return view('stripe.balance-list',['fees'=>$fees]);
    }
 
    public function generatedForm(){ 
        $fees = $this->fee  
                ->orderBy('created_at', 'desc')
                ->with(['user.studentInfo' ])  
                ->with(['payment']) 
                ->get(); 
        return view('fees.generated-form',['fees'=>$fees]);
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


    public function import(Request $request){
        $request->validate([
            'file' => 'required|max:10000|mimes:xlsx,xls',
        ]);

        $path = $request->file('file')->getRealPath();

        try{  
            Excel::import(new FeesImport, $path); 
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
        }
        
        return back()->with('status', __('Uploaded successfully!'));
    }
}

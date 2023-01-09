<?php

namespace App\Http\Controllers;
use App\Services\User\UserService;
use App\Imports\FeesImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\Notification\NotificationService;
use App\Fee;
use App\Payment;

use Illuminate\Http\Request;

class FeeController extends Controller
{
    protected $userService; 
    protected $fee; 
    protected $payment;
    protected $notificationService; 
 

    public function __construct(UserService $userService,Fee $fee,Payment $payment,NotificationService $notificationService ){
        $this->userService = $userService; 
        $this->fee = $fee; 
        $this->payment = $payment; 
        $this->notificationService = $notificationService; 
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
    
    public function editShow($id)
    {
        $students = $this->userService->getAllStudents();
        
        return view('fees.edit',['students'=>$students,'fee'=>$this->fee::where("id",$id)->first()]);
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
            'message' => 'required|string',
            'balance' => 'required|numeric'
        ]); 
        $student_ids = explode(',', $request->student_ids); 
        foreach($student_ids as $student_id){
            $fee = new \App\Fee;
            $fee->fee_name = $request->fee_name;
            $fee->balance = $request->balance;
            $fee->user_id = $student_id;
            $fee->message = $request->message; 
            $fee->school_id = \Auth::user()->school_id;
            $fee->save();
    
            $message = $fee->message;
            $message = str_replace("<br>","\n",$message);
            $message = str_replace("&nbsp;","\t",$message);
            $message = str_replace("<p>","",$message);
            $message = str_replace("</p>","",$message);
            $user = $this->userService->getStudent($fee->user_id);
    
            $sms = $this->notificationService->sendSMS('Dear '.$user->name.', '
            .$message,$user->phone_number);

            $this->notificationService->sendNotification("Payment Notification",'Dear '.$user->name.', '
            .$message,$user);
            
        }


        return back()->with('status', __('Saved'));
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'fee_name' => 'required|string|max:255',
            'message' => 'required|string',
            'balance' => 'required|numeric'
        ]);
        $fee = Fee::find($request->id); 
        $fee->id = $request->id;
        $fee->fee_name = $request->fee_name;
        $fee->balance = $request->balance;
        $fee->message = $request->message; 
        $fee->user_id = $request->student_id; 
        $fee->save();
        return back()->with('status', __('Updated'));
    }

    public function balanceList($user_id){ 
        if(\Auth::user()->role == "student" && \Auth::user()->id != $user_id){
            return redirect("/home"); 
        }
        $fees = $this->fee
                ->with(['payment'=>function($q) use ($user_id){
                    $q->where('user_id',$user_id);
                }])   
                ->where('user_id',$user_id)
                ->orWhere('user_id',0)
                ->get();
        return view('stripe.balance-list',['fees'=>$fees,'user_id'=>$user_id]); 
    }
    
    public function balanceById($user_id,$fee_id){ 
        if(\Auth::user()->role == "student" && \Auth::user()->id != $user_id){
            return redirect("/home"); 
        }
        $fee = $this->fee
                ->where('id',$fee_id)
                ->with(['payment'=>function($q) use ($user_id){
                    $q->where('user_id',$user_id);
                }])   
                ->where( function ( $query ) use ($user_id)
                {
                    $query->where( 'user_id', $user_id )
                        ->orWhere( 'user_id', 0);
                })
                // ->orWhere('user_id',$user_id)
                // ->orWhere('user_id',0)
                ->first();
        return view('stripe.edit-balance',['fee'=>$fee,'user_id'=>$user_id]);
    }

    public function balanceViewById($user_id,$fee_id){ 
        if(\Auth::user()->role == "student" && \Auth::user()->id != $user_id){
            return redirect("/home"); 
        }
        $fee = $this->fee
                ->where('id',$fee_id)
                ->with(['payment'=>function($q) use ($user_id){
                    $q->where('user_id',$user_id);
                }])   
                ->where( function ( $query ) use ($user_id)
                {
                    $query->where( 'user_id', $user_id )
                        ->orWhere( 'user_id', 0);
                })
                // ->where('user_id',$user_id)
                // ->orWhere('user_id',0)
                ->first();
        return view('stripe.view-item-balance',['fee'=>$fee,'user_id'=>$user_id]);
    }
    
 
    public function paidBalanceById(Request $request){ 
        if(\Auth::user()->role == "student" && \Auth::user()->id != $user_id){
            return redirect("/home"); 
        }
        
        $payment = new Payment();
        $payment->fee_id = $request->fee_id ;
        $payment->user_id = $request->user_id ;
        $payment->reference_id = $request->reference_id ;
        $payment->payment_method = $request->payment_method ;
        $payment->payment_status = 1; 
        $payment->save();

        return back()->with('status', __('Paid successfully')); 
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 
        if((Fee::where('id', $id)->firstorfail()->delete())){
            return back()->with('status', __('Deleted')); 
        }else{
            return back()->with('error', __('Encountered an error')); 
        }
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

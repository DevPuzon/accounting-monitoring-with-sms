<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\Fee;
use App\Services\Notification\NotificationService;

class CashierController extends Controller
{
    protected $notificationService; 

    public function __construct(NotificationService $notificationService){ 
        $this->notificationService = $notificationService; 
    }

    public function index(){
        $fees_fields = Fee::bySchool(auth()->user()->school_id)->get();
        return view('stripe.payment', compact('fees_fields'));
    }

    public function store(Request $request,$fee_id,$user_id){
        $pay = Payment::where("fee_id",$fee_id)
        ->where("user_id",$user_id)
        ->first();
        if($pay){ 
            return back()->with('error',__('Payment Unsuccessful. Already paid!'.$pay));
        }

        $stripeToken = $request->stripeToken;
        $amount = intval($request->amount * 100);
        $fee = Fee::select("fee_name")->where("id",$fee_id)->first();
        $user = auth()->user();
        if($user->stripe_id == NULL){
            //manually create a new Customer instance with Stripe
            $user->createAsStripeCustomer([
                'source' =>  $stripeToken 
            ]);
        } 
        try {
            $transaction = $user->charge($amount,null);
            $payment = new Payment;
            $payment->payment_id = $transaction->id;
            $payment->payment_status = 1;
            $payment->amount = $request->amount;  
            $payment->fee_id = $fee_id;
            $payment->user_id = $request->user_id;
            
            $payment->save();

            // $sms = $this->notificationService->sendSMS('Hi '.$user->name.',

            // Thank you for paying the '.$fee->fee_name.' for '.$request->amount.' pesos only.
            // To view the transaction, please proceed to this link '.url('stripe/receipts').'

            // Remember to keep this message for your own.
            // Please feel free to email us if you have any queries.
            
            // Regards, 
            // SLTFCI Admin',$user->phone_number);
            
            // $message = $fee->message;
            // $message = str_replace("<br>","\n",$message);
            // $message = str_replace("&nbsp;","\t",$message);

            // $sms = $this->notificationService->sendSMS('Dear '.$user->name.', '
            // .$message,$user->phone_number);
     

            return back()->with('status',__('Payment Successful'.json_encode($sms)));
        } catch (\Exception $e) {
            return back()->with('error',__('Payment Unsuccessful'));
        } 
    }
}

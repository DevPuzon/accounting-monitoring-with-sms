<?php
namespace App\Services\Notification;

use App\User;
use App\StudentInfo;
use Illuminate\Support\Facades\DB;
use Mavinoo\Batch\Batch as Batch;
use Illuminate\Support\Facades\Log;

class NotificationService {
     

    public function __construct(){ 
    } 

    
    public function sendSMS($msg,$to){
        $curl = curl_init();
  
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.twilio.com/2010-04-01/Accounts/ACbb23b55c8e55d6dd8aed6b374715f16f/Messages',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => 'Body='.urlencode($msg).'&From=%2B19286934249&To=%2B63'.$to.'',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Basic QUNiYjIzYjU1YzhlNTVkNmRkOGFlZDZiMzc0NzE1ZjE2ZjpiNjhlZGM1N2I3ZjVmZGQyZGJjMGIyMWY2MTBlMzU2MQ==',
            'Content-Type: application/x-www-form-urlencoded'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        return ($response)?response()->json([
          'status' => 'success',
          'response'=>json_encode($response),
          'message'=>$msg,
          'to'=>$to,
        ]):response()->json([
          'status' => 'error'
        ]);
    }
}
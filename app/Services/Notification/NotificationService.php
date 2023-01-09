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
        if(!env('IS_SEND_SMS', false)){
          return response()->json([
            'IS_SEND_SMS' => env('IS_SEND_SMS', false)
          ]);
        }

        $curl = curl_init();
  
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.twilio.com/2010-04-01/Accounts/'.env('TWILIO_SID').'/Messages',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => 'Body='.urlencode($msg).'&From=%2B19286934249&To=%2B63'.$to.'',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Basic '.env('TWILIO_AUTH'),
            'Content-Type: application/x-www-form-urlencoded'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);


        return ($response)?response()->json([
          'status' => 'success',
          'response'=>json_encode($response),
          'isSendSMS' => env('IS_SEND_SMS', false),
          'message'=>$msg,
          'to'=>$to,
        ]):response()->json([
          'isSendSMS' => env('IS_SEND_SMS', false),
          'status' => 'error'
        ]);
    }

    public function sendNotification($title,$body,$user){ 
      $curl = curl_init();
      $token = $user->fcm_token;
      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
          "notification": {
              "title":"'.$title.'",
              "body":"'.$body.'",
              "sound": "default",
              "click_action": "FCM_PLUGIN_ACTIVITY",
              "icon": "http://sltfci.xyz/images/logo.jpg"
          },
          "data": {
              "routes": ""
          },
          "to": "'.$token.'",
          "priority": "high",
          "restricted_package_name": ""
      }',
        CURLOPT_HTTPHEADER => array(
          'Authorization: key=AAAAMIZ4bAU:APA91bEqfnocXG7rPng7tuuKjwgrCS5nIZrbuCmIj6dwN5HJ3CmJGOzDW_nt_uvPBfroVSmdUh5b18A04BWHR8u9mFXQRpjYxOcWOJkLtzu_cMpdwEfDhngf1QziXtXJoRga136Wbeyx',
          'Content-Type: application/json'
        ),
      ));

      $response = curl_exec($curl);
      DB::table('notification_logs')->insert([
          ['user_id' => $user->id, 'message' => "$body"]
      ]);
      curl_close($curl);
    }
}
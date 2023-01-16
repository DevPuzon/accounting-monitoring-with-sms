<?php

namespace App\Imports;

use App\Fee;
use App\User; 
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Services\Notification\NotificationService;

class FirstFeeSheetImport implements OnEachRow, WithHeadingRow
{
    protected $class, $section; 
    protected $notificationService; 

    
    public function __construct(NotificationService $notificationService ){ 
        $this->notificationService = $notificationService; 
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function onRow(Row $row)
    {   
        $rowIndex = $row->getIndex();

        if($rowIndex >= 200)
            return;  

        $row = $row->toArray();
 
        if(!$row[__('fee_name')]){
            return;
        }

        $user_id = 0;
        
        $message = $row[__('message')];
        if( strtolower($row[__('student_code')])  == "null" || strtolower($row[__('student_code')])  == "na" ||
            strtolower($row[__('student_code')])  == "none" ||strtolower($row[__('student_code')])  == "n/a"||
            strtolower($row[__('student_code')])  == "all") { 
            $user_id = 0;
            foreach ($this->getAllUser() as $user) {
                $this->notify($user,$message);
            }

        }else if($row[__('student_code')]){
            $user_id =$this->getUserId($row[__('student_code')]); 
            $user =$this->getUser($row[__('student_code')]);
            $this->notify($user,$message);
            if(!$user_id){
                return;
            }
        } 
        $fee = [
            'fee_name'          => $row[__('fee_name')],
            'message'           => $row[__('message')],
            'user_id'           => $user_id,
            'balance'           => $row[__('balance')] 
        ];  
        $tb = create(Fee::class, $fee);     
    }

    public function notify($user,$message){
        $sms = $this->notificationService->sendSMS('Dear '.$user->name.', '
        .$message,$user->phone_number);

        $this->notificationService->sendNotification("Payment Notification",'Dear '.$user->name.', '
        .$message,$user);
    }

    function getUserId($student_code){
        $user = User::where("student_code",$student_code)->first();
        return $user ? $user->id :false;
    }

    function getUser($student_code){
        $user = User::where("student_code",$student_code)->first();
        return $user ? $user :false;
    }

    function getAllUser(){
        $users = User::where("role","student")->get();
        return $users;
    }

    // public function getSectionId(){
    //     if(!empty($this->class) && !empty($this->section)){
    //         $class_id = Myclass::bySchool(auth()->user()->school_id)->where('class_number', $this->class)->pluck('id')->first();

    //         $section = Section::where('class_id', $class_id)->where('section_number', $this->section)->pluck('id')->first();

    //         return $section;
    //     } else {
    //         return 0;
    //     }
    // }
}

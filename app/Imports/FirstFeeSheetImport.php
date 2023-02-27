<?php

namespace App\Imports;

use App\Fee;
use App\User; 
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Services\Notification\NotificationService;
use App\Services\User\UserService; 

class FirstFeeSheetImport implements OnEachRow, WithHeadingRow
{
    protected $class, $section; 
    protected $notificationService,$userService; 

    
    public function __construct(NotificationService $notificationService,UserService $userService ){ 
        $this->notificationService = $notificationService; 
        $this->userService = $userService; 
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
 
        // if(!$row[__('fee_name')]){
        //     return;
        // }

        // $user_id = 0; 
        // $message = $row[__('message')];


        // if( strtolower($row[__('student_code')])  == "null" || strtolower($row[__('student_code')])  == "na" ||
        //     strtolower($row[__('student_code')])  == "none" ||strtolower($row[__('student_code')])  == "n/a"||
        //     strtolower($row[__('student_code')])  == "all") { 
        //     $user_id = 0;
        //     foreach ($this->getAllUser() as $user) {
        //         $this->notify($user,$message);
        //     }

        // }else if($row[__('student_code')]){
        //     $user_id =$this->getUserId($row[__('student_code')]);
        //     $user =$this->getUser($row[__('student_code')]);
        //     $this->notify($user,$message);
        //     if(!$user_id){
        //         return;
        //     }
        // } 

        // $fee = [
        //     'fee_name'          => $row[__('fee_name')],
        //     'message'           => $row[__('message')],
        //     'user_id'           => $user_id,
        //     'balance'           => $row[__('balance')] 
        // ];  
        // $tb = create(Fee::class, $fee);     

        $request =  new \stdClass(); 
        $request->school_year = $row[__('school_year')] ?? '';
        $request->year = $row[__('year')] ?? '';
        $request->semester = $row[__('semester')] ?? '';
        $request->balance = $row[__('balance')] ?? '';
        $request->message = $row[__('message')] ?? '';
        $request->fee_name = $row[__('fee_name')] ?? '';

        $is_all_student = $row[__('is_all_student')] == 'yes' ? true: false;
        $student_ids = array();
        if($is_all_student){ 
            $students = $this->userService->getStudentsWithInfo();
            foreach($students as $student){
                array_push($student_ids,$student->student_id);
            } 
        } 
          
        if($request->year != "" && $request->semester != "" && $request->school_year != ""){
            $student_ids =[];
            $request->fee_name = $request->school_year ." - ". $request->year." Year - " . $request->semester." Semester" ;
            $students = $this->userService->getStudentFilter($request->year,$request->semester,$request->school_year);
            foreach($students as $student){
                array_push($student_ids,$student->student_id);
            } 
        }
        
        if(sizeof($student_ids)>0){  
            foreach($student_ids as $student_id){
                $fee = new \App\Fee;
                $fee->fee_name = $request->fee_name;
                $fee->balance = $request->balance;
                $fee->user_id = $student_id;

                if($request->year != "" && $request->semester != "" && $request->school_year != ""){
                    $fee->year_level = $request->year;
                    $fee->semester =  $request->semester;
                    $fee->school_year =  $request->school_year;
                }

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
        }
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

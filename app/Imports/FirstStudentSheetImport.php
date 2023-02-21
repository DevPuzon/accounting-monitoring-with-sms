<?php

namespace App\Imports;

use App\User;
use App\StudentInfo;
use App\Myclass;
use App\Section;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use App\Services\Notification\NotificationService;

class FirstStudentSheetImport implements ToCollection,OnEachRow, WithHeadingRow
{
    protected $notificationService; 
    protected $message; 

    public function __construct(NotificationService $notificationService,callable $message){ 
        $this->notificationService = $notificationService; 
        $this->message = $message;
    }

    protected $class, $section;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function onRow(Row $row)
    {   
        $rowIndex = $row->getIndex();  
        if($rowIndex >= 200)
            return; // Not more than 200 rows at a time

        $row = $row->toArray();

        // $this->class = (string) $row['class'];
        // $this->section = (string) $row['section'];
        if(!$row['name']){
            return;
        }

        call_user_func($this->message,$rowIndex,"sds");
        // $this->message($rowIndex,"sds");
        $user = User::where('email',$row['email'])->first(); 
        if(!is_null($user)){
            return;
        }
        
        return;
        $user = [
            'name'           => $row['name'],
            'email'          => $row['email'],
            'password'       => Hash::make($row['student_code']),
            'active'         => 1,
            'role'           => 'student',
            'school_id'      => auth()->user()->school_id,
            'code'           => auth()->user()->code,
            'student_code'   => $row['student_code'],
            'address'        => $row['address'],
            // 'about'          => $row['about'],
            'pic_path'       => '',
            'phone_number'   => $row['phone_number'],
            'verified'       => 1,
            // 'section_id'     => $this->getSectionId(),
            // 'blood_group'    => $row['blood_group'],
            // 'nationality'    => $row['nationality'],
            'gender'         => $row['gender'],
        ]; 

        $tb = create(User::class, $user);

        $student_info = [
            'student_id'           => $tb->id,
            'session'              => $row['session'] ?? now()->year,
            // 'version'              => $row['language'] ?? '',
            'course'              => $row['course'] ?? '',
            'major'              => $row['major'] ?? '',
            'year'              => $row['year'] ?? '',
            'semester'              => $row['semester'] ?? '',
            'school_year'              => $row['school_year'] ?? '',
            'group'                => $row['group'] ?? '',
            // 'birthday'             => $row['birthday']?? date('Y-m-d'),
            // 'religion'             => $row['religion'] ?? '',
            // 'father_name'          => $row['father_name'],
            // 'father_phone_number'  => $row['father_phone_number'] ?? '',
            // 'father_national_id'   => $row['father_national_id'] ?? '',
            // 'father_occupation'    => $row['father_occupation'] ?? '',
            // 'father_designation'   => $row['father_designation'] ?? '',
            // 'father_annual_income' => $row['father_annual_income'] ?? '',
            // 'mother_name'          => $row['mother_name'],
            // 'mother_phone_number'  => $row['mother_phone_number'] ?? '',
            // 'mother_national_id'   => $row['mother_national_id'] ?? '',
            // 'mother_occupation'    => $row['mother_occupation'] ?? '',
            // 'mother_designation'   => $row['mother_designation'] ?? '',
            // 'mother_annual_income' => $row['mother_annual_income'] ?? '',
            'user_id' => auth()->user()->id,
        ];

        
    //    $sms = $this->notificationService->sendSMS('Hi '.$row['name'].',

    //    Congratulations! You have successfully created the account. You may use this credential for your account.
       
    //    Email: '.$row['email'].'
    //    Password: '.$row['password'].'
       
    //    Login page:'.url('login').'
       
    //    Please feel free to email us if you have any queries.
       
    //    Regards, 
    //    SLTFCI Admin',$row['phone_number']);
        
        create(StudentInfo::class, $student_info);
    }

    public function collection(Collection $rows){
    //   dd($rows);
      $rowIndex = 0;
      $arrayNames = array();
      foreach($rows as $row){

        if(!$row['name']){
            continue;
        }
        // call_user_func($this->message,$rowIndex,"sds");
        // $this->message($rowIndex,"sds");
        // echo var_dump($row);
        // return;
        
        $user = User::where('email',$row['email'])->orWhere('student_code',$row['student_code'])->first(); 
        $arrayNames[$rowIndex] = $row['name'];
        // call_user_func(json_encode($user));
        // call_user_func(var_dump($row));
        // return;
        if(!is_null($user)){ 
            $error = ["Detected not unique data (".$row['email']."),please check email and student code fields."];
            $failures[] = array($error); 
            throw new \Maatwebsite\Excel\Validators\ValidationException(\Illuminate\Validation\ValidationException::withMessages($error), $failures);
            return;
        }
         
      } 

      foreach($rows as $row){
        $rowIndex ++;  
        if($rowIndex >= 200)
        continue; // Not more than 200 rows at a time

        $row = $row->toArray();

        // $this->class = (string) $row['class'];
        // $this->section = (string) $row['section'];
        if(!$row['name']){
            continue;
        }
        $user = [
            'name'           => $row['name'],
            'email'          => $row['email'],
            'password'       => Hash::make($row['student_code']),
            'active'         => 1,
            'role'           => 'student',
            'school_id'      => auth()->user()->school_id,
            'code'           => auth()->user()->code,
            'student_code'   => $row['student_code'],
            'address'        => $row['address'],
            // 'about'          => $row['about'],
            'pic_path'       => '',
            'phone_number'   => $row['phone_number'],
            'verified'       => 1,
            // 'section_id'     => $this->getSectionId(),
            // 'blood_group'    => $row['blood_group'],
            // 'nationality'    => $row['nationality'],
            'gender'         => $row['gender'],
        ]; 

        $tb = create(User::class, $user);

        $student_info = [
            'student_id'           => $tb->id,
            'session'              => $row['session'] ?? now()->year,
            // 'version'              => $row['language'] ?? '',
            'course'              => $row['course'] ?? '',
            'major'              => $row['major'] ?? '',
            'year'              => $row['year'] ?? '',
            'semester'              => $row['semester'] ?? '',
            'school_year'              => $row['school_year'] ?? '',
            'group'                => $row['group'] ?? '',
            // 'birthday'             => $row['birthday']?? date('Y-m-d'),
            // 'religion'             => $row['religion'] ?? '',
            // 'father_name'          => $row['father_name'],
            // 'father_phone_number'  => $row['father_phone_number'] ?? '',
            // 'father_national_id'   => $row['father_national_id'] ?? '',
            // 'father_occupation'    => $row['father_occupation'] ?? '',
            // 'father_designation'   => $row['father_designation'] ?? '',
            // 'father_annual_income' => $row['father_annual_income'] ?? '',
            // 'mother_name'          => $row['mother_name'],
            // 'mother_phone_number'  => $row['mother_phone_number'] ?? '',
            // 'mother_national_id'   => $row['mother_national_id'] ?? '',
            // 'mother_occupation'    => $row['mother_occupation'] ?? '',
            // 'mother_designation'   => $row['mother_designation'] ?? '',
            // 'mother_annual_income' => $row['mother_annual_income'] ?? '',
            'user_id' => auth()->user()->id,
        ];

        
    //    $sms = $this->notificationService->sendSMS('Hi '.$row['name'].',

    //    Congratulations! You have successfully created the account. You may use this credential for your account.
       
    //    Email: '.$row['email'].'
    //    Password: '.$row['password'].'
       
    //    Login page:'.url('login').'
       
    //    Please feel free to email us if you have any queries.
       
    //    Regards, 
    //    SLTFCI Admin',$row['phone_number']);
        
        create(StudentInfo::class, $student_info);
      }
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

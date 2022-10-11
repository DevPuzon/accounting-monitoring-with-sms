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
use App\Services\Notification\NotificationService;

class FirstStudentSheetImport implements OnEachRow, WithHeadingRow
{
    protected $notificationService; 

    public function __construct(NotificationService $notificationService){ 
        $this->notificationService = $notificationService; 
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

        // $this->class = (string) $row[__('class')];
        // $this->section = (string) $row[__('section')];
        if(!$row[__('name')]){
            return;
        }
        
        $user = [
            'name'           => $row[__('name')],
            'email'          => $row[__('email')],
            'password'       => Hash::make($row[__('student_code')]),
            'active'         => 1,
            'role'           => 'student',
            'school_id'      => auth()->user()->school_id,
            'code'           => auth()->user()->code,
            'student_code'   => $row[__('student_code')],
            'address'        => $row[__('address')],
            // 'about'          => $row[__('about')],
            'pic_path'       => '',
            'phone_number'   => $row[__('phone_number')],
            'verified'       => 1,
            // 'section_id'     => $this->getSectionId(),
            // 'blood_group'    => $row[__('blood_group')],
            'nationality'    => $row[__('nationality')],
            'gender'         => $row[__('gender')],
        ]; 

        $tb = create(User::class, $user);

        $student_info = [
            'student_id'           => $tb->id,
            'session'              => $row[__('session')] ?? now()->year,
            'version'              => $row[__('language')] ?? '',
            'group'                => $row[__('group')] ?? '',
            'birthday'             => $row[__('birthday')]?? date('Y-m-d'),
            'religion'             => $row[__('religion')] ?? '',
            'father_name'          => $row[__('father_name')],
            'father_phone_number'  => $row[__('father_phone_number')] ?? '',
            'father_national_id'   => $row[__('father_national_id')] ?? '',
            'father_occupation'    => $row[__('father_occupation')] ?? '',
            'father_designation'   => $row[__('father_designation')] ?? '',
            'father_annual_income' => $row[__('father_annual_income')] ?? '',
            'mother_name'          => $row[__('mother_name')],
            'mother_phone_number'  => $row[__('mother_phone_number')] ?? '',
            'mother_national_id'   => $row[__('mother_national_id')] ?? '',
            'mother_occupation'    => $row[__('mother_occupation')] ?? '',
            'mother_designation'   => $row[__('mother_designation')] ?? '',
            'mother_annual_income' => $row[__('mother_annual_income')] ?? '',
            'user_id' => auth()->user()->id,
        ];

        
    //    $sms = $this->notificationService->sendSMS('Hi '.$row[__('name')].',

    //    Congratulations! You have successfully created the account. You may use this credential for your account.
       
    //    Email: '.$row[__('email')].'
    //    Password: '.$row[__('password')].'
       
    //    Login page:'.url('login').'
       
    //    Please feel free to email us if you have any queries.
       
    //    Regards, 
    //    SLTFCI Admin',$row[__('phone_number')]);
        
        create(StudentInfo::class, $student_info);
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

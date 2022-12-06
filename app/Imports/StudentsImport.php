<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithValidation;

use App\Services\Notification\NotificationService;

class StudentsImport implements WithMultipleSheets,WithValidation
{
    protected $notificationService; 
    protected $message; 

    public function __construct(NotificationService $notificationService,callable $message){ 
        $this->notificationService = $notificationService; 
        $this->message = $message;
    }

    public function sheets(): array
    {
        return [
            new FirstStudentSheetImport($this->notificationService,$this->message)
        ];
    }

    
    public function rules(): array
    {
        return [
            'namesds' => [
                'required',
                'string',
            ],
        ];
    }
}

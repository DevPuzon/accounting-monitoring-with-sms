<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Services\Notification\NotificationService;

class StudentsImport implements WithMultipleSheets
{
    protected $notificationService; 

    public function __construct(NotificationService $notificationService){ 
        $this->notificationService = $notificationService; 
    }

    public function sheets(): array
    {
        return [
            new FirstStudentSheetImport($this->notificationService)
        ];
    }
}

<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Services\Notification\NotificationService;
use App\Services\User\UserService;

class FeesImport implements WithMultipleSheets
{
    protected $notificationService; 
    protected $userService; 

    
    public function __construct(NotificationService $notificationService,UserService $userService ){ 
        $this->notificationService = $notificationService; 
        $this->userService = $userService; 
    }
    public function sheets(): array
    {
        return [
            new FirstFeeSheetImport($this->notificationService,$this->userService)
        ];
    }
}

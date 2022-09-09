<?php
namespace App\Services\Payment;

use App\Payment; 
use Illuminate\Support\Facades\DB;
use Mavinoo\Batch\Batch as Batch;
use Illuminate\Support\Facades\Log;

class PaymentService {
    
    protected $payment; 
    protected $db;
    protected $batch;
    public function __construct(Payment $payment, DB $db, Batch $batch){
        $this->payment =$payment;  
        $this->db = $db;
        $this->batch = $batch;
    } 

    public function indexView($view, $payments){
        return view($view, [
            'payments' => $payments,
            'current_page' => $payments->currentPage(),
            'per_page' => $payments->perPage(),
        ]);
    }
 
}
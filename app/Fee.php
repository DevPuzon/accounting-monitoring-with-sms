<?php

namespace App;

use App\Model;

class Fee extends Model
{
    //
    public function student()
    {
        return $this->belongsTo('App\Student');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function payment(){
        return $this->hasOne('App\Payment','charged_id');
    }
}

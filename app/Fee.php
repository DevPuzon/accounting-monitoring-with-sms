<?php

namespace App;

use App\Model;

class Fee extends Model
{
    //
    public function student()
    {
        return $this->belongsTo('App\StudentInfo');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function payment(){
        return $this->hasOne('App\Payment','charged_id')
        ->where('user_id',\Auth::user()->id);
    }

    // public function paidByUser($query,$user_id){
    //     return $query->where("user_id",$user)
    // }

}

<?php

namespace App;

use App\Model;

class Payment extends Model
{
    //


    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}

<?php

namespace App;

use App\Model;

class StudentInfo extends Model
{
    protected $table = 'student_infos';
    protected $fillable = array('student_id','year_and_section');
    /**
     * Get the student record associated with the user.
    */
    public function student()
    {
        return $this->belongsTo('App\User');
    }
}

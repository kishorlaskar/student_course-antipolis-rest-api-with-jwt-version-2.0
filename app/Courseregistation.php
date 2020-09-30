<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courseregistation extends Model
{
    protected $table='courseregistations';
    protected $fillable = ['course_fee','course_duration'];
//    public function students()
//    {
//        $this->hasMany(Student::class);
//    }
//    public function courses()
//    {
//        $this->hasMany(Course::class);
//    }

}

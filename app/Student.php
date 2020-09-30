<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table='students';
    protected $fillable = [
        'name', 'email', 'email'
    ];
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    //protected $table='';
     protected $fillable = ['login','wzrost','canLogin','description','born','position','sex'];
}

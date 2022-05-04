<?php

//March 25, 2021, 6:11 pm
namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    //protected $table='';
     protected $fillable = ['login','wzrost','canLogin','description','born','sex','position'];         
     //Relacje  
     
public function Logowanias()
{
   return $this->hasMany(Logowanias::class,'player_id','id');
}
     
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class register extends Authenticatable
{
   protected $fillable=[

        'name','email','password'
   ] ;
}

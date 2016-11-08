<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    protected $table='user';
    protected $fillable=['name','password','code','email'];
}

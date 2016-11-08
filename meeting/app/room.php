<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class room extends Model
{
    protected $table='meetroom';
    protected $fillable=['location','number','admin_phonenumber','full','start_time','end_time'];
}

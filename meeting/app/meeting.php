<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class meeting extends Model
{
   protected $table="meeting";
   protected $fillable=['meeting_name','location','start','start_time','end','end_time',
   							'meeting_info','order_by','info'];
}

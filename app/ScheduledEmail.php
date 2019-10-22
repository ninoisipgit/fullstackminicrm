<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduledEmail extends Model
{
    protected $fillable = [
        'from_name', 'from_email', 'to_name','to_email','message','sched_date'
    ];
}

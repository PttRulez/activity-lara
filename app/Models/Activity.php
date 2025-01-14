<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public Carbon $startTime;
    
    protected $guarded = ['id'];
    protected $casts = ['date' => 'date'];
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogHistory extends Model
{
    protected $table = 'log_history';
    protected $fillable = ['user_id', 'className', 'functionName', 'description', 'ip_address'];
}

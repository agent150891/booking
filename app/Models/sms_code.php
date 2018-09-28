<?php

namespace Svityaz\Models;

use Illuminate\Database\Eloquent\Model;

class sms_code extends Model
{
    protected $table="sms_codes";
    protected $fillable = [
        'phone', 'code',
    ];

}

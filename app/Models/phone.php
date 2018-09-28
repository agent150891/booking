<?php

namespace Svityaz\Models;

use Illuminate\Database\Eloquent\Model;

class phone extends Model
{
    //
    protected $fillable = [
        'phone', 'user_id',
    ];
    protected $table = 'phones';
    public $timestamps = false;
}

<?php

namespace Svityaz\Models;

use Illuminate\Database\Eloquent\Model;

class paidType extends Model
{
    protected $table="paid_types";
    protected $fillable=['type'];
}

<?php

namespace Svityaz\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class paidScheme extends Model
{
    use SoftDeletes;
    protected $table="paid_schemes";
    protected $fillable=['ptype_id','name','days','price','created_at'];
    public function type(){
      return $this->belongsTo('Svityaz\Models\paidType','ptype_id','id');
    }
}

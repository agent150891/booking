<?php

namespace Svityaz\Models;

use Illuminate\Database\Eloquent\Model;

class genpass extends Model
{
     static function genPass($length=5){//генератор паролей
        $arr = 'QWERTYUIOPASDFGHJKLZXCVBNM1234567890';
        $pass = '';
        for ($i=0; $i < $length ; $i++) { 
            $pass .= $arr[rand(0, strlen($arr) - 1)];
        }
        return $pass;
    }
}

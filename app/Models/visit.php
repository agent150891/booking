<?php

namespace Svityaz\Models;

use Illuminate\Database\Eloquent\Model;


class visit extends Model
{
    //
    static function visit()
    {
        $host = $_SERVER['REMOTE_ADDR'];
        $now = date('Y-m-d', time());
        $v = \DB::table('visits')->where('host', '=', $host)->where('created_at', 'like', $now.'%')->first();
        if ($v){
            $v->visits++;
            $v->updated_at = date('Y-m-d H:i:s',time());
            //$v->save();
            \DB::table('visits')->where('id','=',$v->id)->update(['updated_at'=>$v->updated_at, 'visits'=>$v->visits]);
            return true;
        } else{
            \DB::table('visits')->insert(['host'=>$host,
                                        'visits'=>1,
                                        'updated_at' => date('Y-m-d H:i:s',time()),
                                        'created_at' => date('Y-m-d H:i:s',time()),
                                    ]);
        }
        return true;
    }
}

<?php

namespace Svityaz\Models;

use Illuminate\Database\Eloquent\Model;

class sms extends Model
{
    protected $table="sms";

    static function send($destination,$message,$about=''){
	    $data=array('destination'=>$destination,'message'=>$message,'about'=>$about);

	    session(['sms_mess'=>$message]);
        session(['sms_phone'=>$destination]);
        $client = new \SoapClient('http://turbosms.in.ua/api/wsdl.html');
        $login = 'SiriusWiFi';
        $pass = 'babka007';
        $sign = 'SiriusWiFi';
        $auth = [
        'login' => $login,
        'password' => $pass,
        ];
        $client->Auth($auth);
        $s = [
            'sender' => $sign,
            'destination' => '+'.$destination,
            'text' => $message
        ];
        $result = $client->SendSMS($s);
        \DB::table('sms')->insert([
	    	'destination'=>$destination,
	    	'message'=>$message,
	    	'about'=>$about,
            'status'=>$result->SendSMSResult->ResultArray[0] . PHP_EOL,
            'turbo_id'=>$result->SendSMSResult->ResultArray[1] . PHP_EOL,
	    	'created_at'=>date('Y-m-d H:i:s',time()),
	    ]);
	    return true;
    }
}

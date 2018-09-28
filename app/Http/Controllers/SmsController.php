<?php

namespace Svityaz\Http\Controllers;

use Illuminate\Http\Request;
use Svityaz\Models\sms as SmsModel;
use Svityaz\Models\genpass;
use Svityaz\Models\sms_code;

class SmsController extends Controller
{
    public function smsSend(Request $request){//отправка СМС
        SmsModel::send($request->phone, $request->message, $request->about);
        echo 'OK';
    }

    public function smsGet(){//получение СМС из сессии
        echo json_encode(["message"=>session('sms_mess'), "phone"=>session('sms_phone')]);
    }

  public function smsSendCode(Request $request){//отправка СМС с кодом
    $phone = $request->phone;
        if (count(sms_code::where('phone','=',$phone)->get())>0){//телефон уже есть втаблице кодов
          $code =sms_code::where('phone','=',$phone)->first();
          echo "old";
        } else{
          $code = new sms_code;
          $code->phone = $phone;
          echo "new";
        }
        $code->code = genpass::genPass();//генерация нового кода
        $code->save();
        SmsModel::send($phone, 'пароль:'.$code->code, $request->about);
    }

    public function test(){

    }
}

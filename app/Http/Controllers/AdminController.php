<?php

namespace Svityaz\Http\Controllers;

use Illuminate\Http\Request;
use Svityaz\Models\sms as SmsModel;
use Svityaz\Models\hotelTypes;
use Svityaz\Models\genpass;
use Svityaz\Models\sms_code;
use Svityaz\Models\cities;
use Svityaz\Models\beach;
use Svityaz\User;
use Svityaz\Models\hotels;
use Svityaz\Models\rooms;
use Svityaz\Models\phone;
use Svityaz\Models\feed;
use Svityaz\Models\visit;
use Svityaz\Models\paidScheme;
use Svityaz\Models\paidType;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    //
    public function index(Request $request)
    {
        $db_photos = []; //фотографии которые есть в базе
        $room_photos = \DB::table('rooms')->select('foto1','foto2','foto3','foto4','foto5')->get();
        foreach ($room_photos as $r) {
            $db_photos[] =$r->foto1;
            if ($r->foto2 != '') $db_photos[] = $r->foto2;
            if ($r->foto3 != '') $db_photos[] = $r->foto3;
            if ($r->foto4 != '') $db_photos[] = $r->foto4;
            if ($r->foto5 != '') $db_photos[] = $r->foto5;
        }
        $hotel_photos = \DB::table('hotels')->select('foto1','foto2','foto3','foto4','foto5')->get();
        foreach ($hotel_photos as $h) {
            $db_photos[] = $h->foto1;
            if ($h->foto2 != '') $db_photos[] = $h->foto2;
            if ($h->foto3 != '') $db_photos[] = $h->foto3;
            if ($h->foto4 != '') $db_photos[] = $h->foto4;
            if ($h->foto5 != '') $db_photos[] = $h->foto5;
        }
        $stor = Storage::files('images'); // фотограции на диске
        foreach ($stor as $s) {
            $find = false;
            foreach ($db_photos as $db) {
                if ($s == $db){
                    $find = true;
                }
            }
            if (!$find){
                Storage::delete($s);// удаление ненужных фото с диска
            }
        }
        $data = [];
        return view('admin/login', $data);
        //return view('admin/index', $data);
    }
    public function statistic(Request $request)
    {
        $active = hotels::where('date_out', '>', date('Y-m-d H:i:s',time()))->count();
        $passive = hotels::where('date_out','<', date('Y-m-d H:i:s',time()))->count();
        $all_adds = $passive+$active;
        $all_hotel = hotels::count();
        $all_visits = visit::sum('visits');
        $visit24 = visit::where('updated_at','>',date('Y-m-d H:i:s',time()-24*60*60))->sum('visits');
        $visit1 = visit::where('updated_at','>',date('Y-m-d H:i:s',time()-60*60))->count('id');
        $client = new \SoapClient('http://turbosms.in.ua/api/wsdl.html');
        $auth = [
        'login' => 'SiriusWiFi',
        'password' => 'babka007',
        ];
        $client->Auth($auth);
        $sms_amount = $client->GetCreditBalance();
        $sms_all = SmsModel::where('turbo_id','!=','null')->count();
        $pay_adds = hotels::where('date_pay', '>=', date('Y-m-d H:i:s',time()))->count();
        $unpay_adds = hotels::where('date_pay', '<', date('Y-m-d H:i:s',time()))->count();
        $data = ['active'=>$active,
                'passive'=>$passive,
                'all_adds'=>$all_adds,
                'all_hotels'=>$all_hotel,
                'all_visits'=>$all_visits,
                'visit24'=>$visit24,
                'visit1'=>$visit1,
                'sms_amount'=>$sms_amount,
                'sms_all'=>$sms_all,
                'pay_adds'=>$pay_adds,
                'unpay_adds'=>$unpay_adds,
        ];
        return view('admin/statistic', $data);
    }
    public function hotels(Request $request)
    {
        $hotel_types = hotelTypes::get();
        $hotels = hotels::get();
        for ($i=0; $i<count($hotels);$i++){
            $phone = phone::where('user_id', '=', $hotels[$i]->user_id)->first();
            $hotels[$i]->phone = $phone->phone;
        }
        $cities = cities::get();
        $data = ['hotels'=>$hotels,
                'hotel_types'=>$hotel_types,
                'cities'=>$cities,
        ];
        return view('admin/hotels', $data);
    }

    public function users(Request $request)
    {
        $users = User::get();
        for ($i=0; $i <count($users) ; $i++) {
            $phone = phone::where('user_id','=',$users[$i]->id)->orderBy('id','asc')->first();
            $users[$i]->phone = $phone->phone;
        }
        $data = ['users'=>$users];
        return view('admin/users', $data);
    }

    public function pays(Request $request)
    {
        $data = [];
        return view('admin/pays', $data);
    }
    public function paidservices(Request $request)
    {
        $paids = paidScheme::get();
        $types = paidType::get();
        $data = ['paids'=>$paids,
                'types'=>$types
                ];
        return view('admin/paidservices', $data);
    }
    public function features(Request $request)
    {
        $data = [];
        return view('admin/features', $data);
    }
    public function sms(Request $request)
    {
        $data = [];
        return view('admin/sms', $data);
    }
    public function cities(Request $request)
    {
        $cities = cities::get();
        $data = ['cities'=>$cities];
        return view('admin/cities', $data);
    }
    public function other(Request $request)
    {
        $data = [];
        return view('admin/other', $data);
    }

    public function hotelinfo(Request $request)
    {
        $hotel = hotels::find($request->hotel_id);
        echo json_encode($hotel);
    }

    public function roomsInfo(Request $request)
    {
        $rooms = rooms::where('hotel_id', $request->id)->get();
        echo json_encode($rooms);
    }

    public function roomInfo($id)
    {
        $room = rooms::find($id);
        if ($room){
            echo json_encode($room);
        } else{
            echo false;
        }
    }

    public function userInfo($id)
    {
        $user = User::find($id);
        if ($user){
            $phones = phone::where('user_id', '=', $user->id)->orderBy('id','asc')->get();
            $data = ['user'=>$user, 'phones'=>$phones];
            echo json_encode($data);
        } else{
            echo 0;
        }
    }

    public function filterhotels(Request $request)
    {
        $hotels = hotels::where('title', 'like' , '%'.$request->filter.'%')->orWhere('about', 'like' , '%'.$request->filter.'%')->get();
        for ($i=0; $i<count($hotels);$i++){
            $hotels[$i]->phone = phone::where('user_id','=',$hotels[$i]->user_id)->first()->value('phone');
        }
        echo json_encode($hotels);
    }

    public function saveHotel(Request $request)
    {
        if (!preg_match('/^\d{1,}$/i' , $request->edit_id)) return 'error id';
        if (!preg_match('/^.{2,50}$/i' , trim($request->tittle))) return 'error hotel name';
        if (!preg_match('/^\d{1,}$/i' , $request->htype)) return 'error hotel type';
        if (!preg_match('/^\d{1,}$/i' , $request->city)) return 'error city';
        if (!preg_match('/^.{5,100}$/i' , trim($request->address))) return 'error address';
        if (!preg_match('/^.{3,255}$/i' , trim($request->text))) return 'error about';
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/i' , $request->create_date)) return 'error create date';
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/i' , $request->date_out)) return 'error date_out';
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/i' , $request->date_top)) return 'error date_top';
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/i' , $request->date_pay)) return 'error date_pay';
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/i' , $request->date_vip)) return 'error date_vip';
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/i' , $request->date_up)) return 'error date_up';
        if (!preg_match('/^\d{1,3}$/i' , $request->rooms)) return 'error rooms number';
        if (!preg_match('/^\d{1,3}$/i' , $request->lux)) return 'error lux rooms number';
        if (!preg_match('/^\d{1,5}$/i' , $request->to_beach)) return 'error to beach distance';
        if (!preg_match('/^\d{1,5}$/i' , $request->to_shop)) return 'error to shop distance';
        if (!preg_match('/^\d{1,5}$/i' , $request->to_rest)) return 'error to restoran distance';
        if (!preg_match('/^\d{1,5}$/i' , $request->to_bus)) return 'error to bus stop distance';
        if (!preg_match('/^\d{1,5}$/i' , $request->to_disco)) return 'error to disco distance';
        if (!preg_match('/^\d{1,4}$/i' , $request->price)) return 'error price';
        $hotel = hotels::find($request->edit_id);
        if (!$hotel) return 'wrong hotel id';
        if (!cities::find($request->city)) return 'wrong city id';
        if (!hotelTypes::find($request->htype)) return 'wrong hotel type';
        $hotel->title = trim($request->tittle);
        $hotel->hotel_type_id = $request->htype;
        $hotel->city_id = $request->city;
        $hotel->address = trim($request->address);
        $hotel->about = trim($request->text);
        $hotel->created_at = $request->create_date;
        $hotel->date_out = $request->date_out;
        $hotel->date_top = $request->date_top;
        $hotel->date_pay = $request->date_pay;
        $hotel->date_vip = $request->date_vip;
        $hotel->date_up = $request->date_up;
        $hotel->rooms = $request->rooms;
        $hotel->lux = $request->lux;
        $hotel->to_beach = $request->to_beach;
        $hotel->to_rest = $request->to_rest;
        $hotel->to_disco = $request->to_disco;
        $hotel->to_bus = $request->to_bus;
        $hotel->to_shop = $request->to_shop;
        $hotel->bath = $request->bath;
        $hotel->parking = $request->parking;
        $hotel->kids = $request->kids;
        $hotel->kitchen = $request->kitchen;
        $hotel->altan = $request->altan;
        $hotel->price = $request->price;
        $hotel->price_type = $request->price_type;
        $hotel->save();
        echo 0;
    }

    public function saveRoom(Request $request)
    {
        if (!preg_match('/^\d{1,}$/i' , $request->id)) return 'error id';
        if (!preg_match('/^.{2,50}$/i' , trim($request->title))) return 'error room name';
        if (!preg_match('/^.{3,255}$/i' , trim($request->about))) return 'error about';
        if (!preg_match('/^\d{1,4}$/i' , $request->price)) return 'error price';
        if (!preg_match('/^\d{1,3}$/i' , $request->beds)) return 'error beds number';
        if (!preg_match('/^\d{1}$/i' , $request->price_type)) return 'error price_type';
        if (!preg_match('/^\d{1}$/i' , $request->wc)) return 'error wc';
        if (!preg_match('/^\d{1}$/i' , $request->tv)) return 'error tv';
        if (!preg_match('/^\d{1}$/i' , $request->cond)) return 'error cond';
        if (!preg_match('/^\d{1}$/i' , $request->bath)) return 'error bath';
        if (!preg_match('/^\d{1}$/i' , $request->kitchen)) return 'error kitchen';
        if (!preg_match('/^\d{1}$/i' , $request->holo)) return 'error holo';
        if (!preg_match('/^\d{1}$/i' , $request->wifi)) return 'error wifi';
        $room = rooms::find($request->id);
        if (!$room) return 'wrong room id';
        $room->title = $request->title;
        $room->about = $request->about;
        $room->price = $request->price;
        $room->beds = $request->beds;
        $room->price_type = $request->price_type;
        $room->wc = $request->wc;
        $room->tv = $request->tv;
        $room->cond = $request->cond;
        $room->bath = $request->bath;
        $room->kitchen = $request->kitchen;
        $room->holo = $request->holo;
        $room->wifi = $request->wifi;
        $room->save();
        echo 0;
    }

    public function deleteRoom($id)
    {
        $room = rooms::find($id);
        if ($room){
            $room->delete();
            echo 0;
        } else{
            echo 'wrong room number';
        }
    }

    public function userSave(Request $request)
    {
        if (!preg_match('/^[012]{1}$/i' , $request->status)) return 'error status';
        $user = User::find($request->id);
        if (!$user) return 'error user id';
        $user->role = $request->status;
        $user->save();
        return '0';
    }

    public function editCity(Request $request)
    {
        if (!preg_match('/^\d{1,}$/i' , $request->id)) return 'error id='.$request->id;
        if (!preg_match('/^.{3,50}$/i' , trim($request->city))) return 'error city name';
        if (!preg_match('/^\d{2}[.]\d{1,}$/i' , $request->gps_alt)) return 'error altitude';
        if (!preg_match('/^\d{2}[.]\d{1,}$/i' , $request->gps_lng)) return 'error longtitude';
        $city = cities::find($request->id);
        if (!$city) return 'wrong id';
        $city->city = $request->city;
        $city->gps_alt = $request->gps_alt;
        $city->gps_lng = $request->gps_lng;
        $city->save();
        return '0';
    }

    public function addCity(Request $request)
    {
        if (!preg_match('/^.{3,50}$/i' , trim($request->city))) return 'error city name';
        if (!preg_match('/^\d{2}[.]\d{1,}$/i' , $request->gps_alt)) return 'error altitude';
        if (!preg_match('/^\d{2}[.]\d{1,}$/i' , $request->gps_lng)) return 'error longtitude';
        $city = new cities;
        $city->city = $request->city;
        $city->gps_alt = $request->gps_alt;
        $city->gps_lng = $request->gps_lng;
        $city->save();
        return '0';
    }

    public function citiesList(Request $request)
    {
        $cities = cities::get();
        echo json_encode($cities);
    }

    public function feeds(Request $request)
    {
        $feeds = feed::list(1);
        $data = ['feeds'=>$feeds];
        return view('admin/feeds', $data);
    }

    public function filterFeeds(Request $request)
    {
        $feeds = feed::list($request->page, $request->filter);
        echo json_encode($feeds);
    }

    public function feedSt(Request $request)
    {
        $feed = feed::find($request->id);
        if (!$feed) return 'wrong id';
        switch ($request->status) {
            case 's':
                $feed->status = 1;
                $feed->save();
                break;
            case 'b':
                $feed->status = 0;
                $feed->save();
                break;
            case 'd':
                $feed->delete();
                break;
            default:
                return 'wrong new status';
                break;
        }

        return '0';
    }

    public function addPayScheme(Request $request)
    {
        if (!preg_match('/^\d{1,}$/i' , $request->paid_type)) return 'error paid type';
        $type = paidType::find($request->paid_type);
        if (!$type) return 'error paid type';
        if (!preg_match('/^.{2,50}$/i' , trim($request->paid_name))) return 'error name';
        if (!preg_match('/^\d{1,5}$/i' , $request->paid_days)) return 'error days';
        if (!preg_match('/^\d{1,6}$/i' , $request->paid_price)) return 'error paid price';
        $s = new paidScheme;
        $s->ptype_id = $request->paid_type;
        $s->name = $request->paid_name;
        $s->days = $request->paid_days;
        $s->price = $request->paid_price;
        $s->save();
        return 0;
    }

    public function delPayScheme(Request $request)
    {
        $s = paidScheme::find($request->id);
        if (!$s) return 'wrong id';
        $s->delete();
        return 0;
    }

    public function editPayScheme(Request $request)
    {
        if (!preg_match('/^\d{1,}$/i' , $request->paid_type)) return 'error paid type';
        $type = paidType::find($request->paid_type);
        if (!$type) return 'error paid type';
        if (!preg_match('/^.{2,50}$/i' , trim($request->paid_name))) return 'error name';
        if (!preg_match('/^\d{1,5}$/i' , $request->paid_days)) return 'error days';
        if (!preg_match('/^\d{1,6}$/i' , $request->paid_price)) return 'error paid price';
        if (!preg_match('/^\d{1,}$/i' , $request->paid_id)) return 'error id';
        $s = paidScheme::find($request->paid_id);
        if (!$s) return 'error id';
        $s->ptype_id = $request->paid_type;
        $s->name = $request->paid_name;
        $s->days = $request->paid_days;
        $s->price = $request->paid_price;
        $s->save();
        return 0;
    }

    public function showPayScheme(Request $request)
    {
        $s = paidScheme::get();
        for ($i=0; $i < count($s) ; $i++) {
            $s[$i]->type_name = $s[$i]->type->type;
        }
        echo json_encode($s);
    }
}

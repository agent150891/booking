<?php

namespace Svityaz\Http\Controllers;

use Illuminate\Http\Request;
use Svityaz\Models\cities;
use Svityaz\Models\hotelTypes;
use Svityaz\Models\hotels as HotelModel;
use Illuminate\Support\Facades\Cache;
use Svityaz\User;
use Svityaz\Models\visit;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeController extends Controller
{
    public function index(){
        visit::visit();
        $cities = cities::all();
        $hotel_types = hotelTypes::all();
        $hotels =  HotelModel::list(1);
        $visit_list = [];
        if (Cache::has('visit')){
            $visit = explode(',', Cache::get('visit'));
            foreach ($visit as $v) {
                if (substr($v,0,1)=='h'){
                    $h = HotelModel::find(substr($v,1));
                    $visit_list[]=[
                        'foto'=>$h->foto1,
                        'title'=>$h->title,
                        'price'=>$h->price,
                        'price_type'=>($h->price_type==0) ? 'грн./доба':'грн./ліжко',
                        'link'=>"hotel/".$h->id,
                    ];
                }
            }
        }
        $data = ['cities' => $cities,
                'htypes'=>$hotel_types,
                'hotels'=>$hotels,
                'visits'=>$visit_list,
                'cuser'=>User::getCurrent(),
                ];
        return view('welcome', $data);
    }
}

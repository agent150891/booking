<?php

namespace Svityaz\Http\Controllers;

use Svityaz\Models\hotels;
use Svityaz\Models\rooms;
use Illuminate\Http\Request;
use Svityaz\Models\cities;
use Svityaz\Models\hotelTypes;
use Svityaz\User;
use Svityaz\Models\phone;
use Svityaz\Models\feed;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \Svityaz\Model\hotels  $hotels
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $hotel = hotels::findOrFail($id);
        if (Cache::has('visit')){//были посещения
            $visit = explode(',', Cache::get('visit'));
        } else {//не было посещений
            $visit = [];
        }
        if (!in_array('h' . $hotel->id, $visit)){//ещё не посещал это объявление
            if (count($visit) > 3){// нет мест в ленте
                array_splice($visit, 0, 1);
            }
            $visit[] = 'h'.$hotel->id;
            Cache::put('visit',implode(',',$visit),480);
        }
        $user = User::findOrFail($hotel->user_id);
        $phone = phone::where('user_id','=',$hotel->user_id)->orderBy('id', 'asc')->first();
        $cities = cities::all();
        $hotel_types = hotelTypes::all();
        $city = cities::findOrFail($hotel->city_id);
        $feeds = feed::where('hotel_id','=',$hotel->id)->where('reight','!=',0)->latest()->take(4)->get();
        for($i=0;$i<count($feeds);$i++){
            if ($feeds[$i]->feed_id>0){
                $rfeed = feed::find($feeds[$i]->feed_id);
                $feeds[$i]->re = $rfeed->comment;
                $feeds[$i]->rname = $rfeed->name;
                //echo 'id='.$feeds[$i]->feeds_id.'<br>';
                //echo 're='.$feeds[$i]->re.'<br>';
            } else{
                //echo 'no re <br>';
                $feeds[$i]->re ='no re';
                $feeds[$i]->name ='noname';
            }
        }
        $visit_list = [];
        if (Cache::has('visit')){
            $visit = explode(',', Cache::get('visit'));
            foreach ($visit as $v) {
                if (substr($v,0,1)=='h'){
                    $h = hotels::find(substr($v,1));
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
                'user'=>$user,
                'phone'=>$phone,
                'hotel_city'=>$city,
                'feeds'=>$feeds,
                'visits'=>$visit_list,
                'cuser'=>User::getCurrent(),
                'hotel'=>$hotel];
        return view('hotel/show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Svityaz\Model\hotels  $hotels
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hotel = hotels::findOrFail($id);
        $user = User::findOrFail($hotel->user_id);
        if ($hotel->user_id != session('user_id')){
            return redirect('cabinet');
        }
        $phones = phone::where('user_id','=',$hotel->user_id)->get();
        $cities = cities::all();
        $hotel_types = hotelTypes::all();
        $city = cities::findOrFail($hotel->city_id);
        $data = ['cities' => $cities,
                'htypes'=>$hotel_types,
                'user'=>$user,
                'phones'=>$phones,
                'hotel_city'=>$city,
                'cuser'=>User::getCurrent(),
                'hotel'=>$hotel];
        return view('hotel/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Svityaz\Model\hotels  $hotels
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $hotel_id)
    {
        if (!preg_match('/^.{2,30}$/i' , $request->hotel['title'])) return 'error';
        if (!preg_match('/^.{5,50}$/i' , $request->hotel['address'])) return 'error';
        if (!preg_match('/^.{2,249}$/i' , $request->hotel['about'])) return 'error';
        if (!preg_match('/^\d{1,4}$/i' , $request->hotel['price'])) return 'error';
        if (!preg_match('/^\d{1,4}$/i' , $request->hotel['to_beach'])) return 'error';
        if (!preg_match('/^\d{1,4}$/i' , $request->hotel['to_shop'])) return 'error';
        if (!preg_match('/^\d{1,4}$/i' , $request->hotel['to_rest'])) return 'error';
        if (!preg_match('/^\d{1,4}$/i' , $request->hotel['to_bath'])) return 'error';
        if (!preg_match('/^\d{1,4}$/i' , $request->hotel['to_disco'])) return 'error';
        if (!preg_match('/^\d{1,3}$/i' , $request->hotel['lux'])) return 'error';
        if (!preg_match('/^\d{1,3}$/i' , $request->hotel['rooms'])) return 'error';
        $hotel = hotels::find($hotel_id);
        $hotel->city_id = $request->hotel['city_id'];
        $hotel->bath = $request->hotel['bath'];
        $hotel->parking = $request->hotel['parking'];
        $hotel->kitchen = $request->hotel['kitchen'];
        $hotel->altan = $request->hotel['altan'];
        $hotel->kids = $request->hotel['kids'];
        $hotel->hotel_type_id = $request->hotel['hotel_type_id'];
        $hotel->gps_alt = $request->hotel['gps_alt'];
        $hotel->gps_lng = $request->hotel['gps_lng'];
        $hotel->title = $request->hotel['title'];
        $hotel->address = $request->hotel['address'];
        $hotel->rooms = $request->hotel['rooms'];
        $hotel->lux = $request->hotel['lux'];
        $hotel->about = $request->hotel['about'];
        $hotel->price = $request->hotel['price'];
        $hotel->price_type = $request->hotel['price_type'];
        $hotel->to_beach = $request->hotel['to_beach'];
        $hotel->to_shop = $request->hotel['to_shop'];
        $hotel->to_disco = $request->hotel['to_disco'];
        $hotel->to_rest = $request->hotel['to_rest'];
        $hotel->to_bus = $request->hotel['to_bus'];
        $count_photos = count($request->hotel['photos']);
        $hotel->foto1 = $request->hotel['photos'][0];
        $hotel->foto2 = $request->hotel['photos'][1];
        $hotel->foto3 = $request->hotel['photos'][2];
        $hotel->foto4 = $request->hotel['photos'][3];
        $hotel->foto5 = $request->hotel['photos'][4];
        $hotel->save();
        echo "data saved";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Svityaz\Model\hotels  $hotels
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hotel = hotels::find($id);
        $rooms = rooms::where('hotel_id','=',$id)->get();
        foreach ($rooms as $room) {
            $room->delete();
        }
        $hotel->delete();
        echo 'deleted hotel id='.$id;
    }

    public function delete($id)
    {
        $hotel = hotels::find($id);
        if ($hotel->user_id == session('user_id')){
            $rooms = rooms::where('hotel_id','=',$id)->get();
            foreach ($rooms as $room) {
                $room->delete();
            }
            $hotel->delete();
        }
        $visit_list = [];
        if (Cache::has('visit')){
            $visit = explode(',', Cache::get('visit'));
            foreach ($visit as $v) {
                if (substr($v,0,1) != 'h' &&  $id != substr($v,1)){
                    $visit_list[] = 'h'.substr($v,1);
                }
            }
            Cache::put('visit',implode(',',$visit_list),480);
        }
        return redirect('cabinet');
    }

    public function paggination(Request $request)
    {
        $list = hotels::list($request->page, $request->filter);
        echo json_encode($list);
    }

    public function feeds($hotel_id)
    {
        $hotel = hotels::find($hotel_id);
        if ($hotel->user_id!=session('user_id')){
            return redirect('cabinet');
        }
        $user = User::find($hotel->user_id);
        $phone = phone::where('user_id','=',$user->id)->orderBy('id', 'asc')->first();
        $feeds = feed::where('hotel_id','=',$hotel->id)->where('reight','!=','0')->get();
        $cities = cities::all();
        $hotel_types = hotelTypes::all();
        $data =[
            'hotel'=>$hotel,
            'user'=>$user,
            'phone'=>$phone,
            'feeds'=>$feeds,
            'cities'=>$cities,
            'htypes'=>$hotel_types,
            'cuser'=>User::getCurrent(),
        ];
        return view('hotel/feeds', $data);
    }
}

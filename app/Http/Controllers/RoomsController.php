<?php

namespace Svityaz\Http\Controllers;

use Svityaz\Models\rooms;
use Illuminate\Http\Request;
use Svityaz\Models\hotels;
use Svityaz\Models\cities;
use Svityaz\Models\hotelTypes;
use Svityaz\User;
use Svityaz\Models\phone;
use Svityaz\Models\booking;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomsController extends Controller
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
     * @param  \Svityaz\Models\rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function show($room_id)
    {
        //
        $room = rooms::findOrFail($room_id);
        $hotel = hotels::findOrFail($room->hotel_id);
        $user = User::findOrFail($hotel->user_id);
        /////$phone = phone::findOrFail($hotel->user_id);
        $phone = phone::where('user_id','=',$hotel->user_id)->orderBy('id', 'asc')->first();
        $city = cities::findOrFail($hotel->city_id);
        $cities = cities::all();
        $hotel_types = hotelTypes::all();
        $data = ['cities' => $cities,
                'htypes'=>$hotel_types,
                'user'=>$user,
                'phone'=>$phone,
                'room'=>$room,
                'hotel_city'=>$city,
                'cuser'=>User::getCurrent(),
                'hotel'=>$hotel];
        return view('room/show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Svityaz\Models\rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function edit($hotel_id)
    {
        //
        $rooms = rooms::where('hotel_id','=',$hotel_id)->get();
        $hotel = hotels::findOrFail($hotel_id);
        $user = User::findOrFail($hotel->user_id);
        $phone = phone::where('user_id','=',$hotel->user_id)->orderBy('id', 'asc')->orderBy('id', 'asc')->first();
        $cities = cities::all();
        $hotel_types = hotelTypes::all();
        $data = ['cities' => $cities,
                'htypes'=>$hotel_types,
                'user'=>$user,
                'phone'=>$phone,
                'rooms'=>$rooms,
                'cuser'=>User::getCurrent(),
                'hotel'=>$hotel];
        return view('room/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Svityaz\Models\rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!preg_match('/^.{1,50}$/i' , $request->title)) return 'error';
        if (!preg_match('/^.{1,249}$/i' , $request->about)) return 'error';
        if (!preg_match('/^\d{1,4}$/i' , $request->price)) return 'error';
        if (!preg_match('/^\d{1,2}$/i' , $request->beds)) return 'error';
        if (!preg_match('/^[01]$/i' , $request->price_type)) return 'error';
        if (!preg_match('/^[01]$/i' , $request->wc)) return 'error';
        if (!preg_match('/^[01]$/i' , $request->bath)) return 'error';
        if (!preg_match('/^[01]$/i' , $request->tv)) return 'error';
        if (!preg_match('/^[01]$/i' , $request->cond)) return 'error';
        if (!preg_match('/^[01]$/i' , $request->holo)) return 'error';
        if (!preg_match('/^[01]$/i' , $request->kitchen)) return 'error';
        $room = rooms::find($request->id);
        $room->title = $request->title;
        $room->beds = $request->beds;
        $room->price = $request->price;
        $room->price_type = $request->price_type;
        $room->foto1 = $request->foto1;
        $room->foto2 = $request->foto2;
        $room->foto3 = $request->foto3;
        $room->foto4 = $request->foto4;
        $room->foto5 = $request->foto5;
        $room->foto6 = $request->foto6;
        $room->about = $request->about;
        $room->wc = $request->wc;
        $room->bath = $request->bath;
        $room->tv = $request->tv;
        $room->cond = $request->cond;
        $room->holo = $request->holo;
        $room->kitchen = $request->kitchen;
        $room->save();
        echo "save OK";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Svityaz\Models\rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function destroy(rooms $rooms)
    {
        //
    }
    public function roomsList($id)
    {
        $rooms = rooms::list(1, $id);
        $hotel = hotels::findOrFail($id);
        $user = User::findOrFail($hotel->user_id);
        $phone = phone::where('user_id','=',$hotel->user_id)->orderBy('id', 'asc')->orderBy('id', 'asc')->first();
        $cities = cities::all();
        $hotel_types = hotelTypes::all();
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
                'rooms'=>$rooms,
                'cuser'=>User::getCurrent(),
                'visits'=>$visit_list,
                'hotel'=>$hotel];
        return view('room/list', $data);
    }

    public function paggination(Request $request)
    {
        $list = rooms::list($request->page, $request->hotel_id);
        echo json_encode($list);
    }

    public function getList(Request $request)
    {
        $rooms= rooms::where('hotel_id','=',$request->hotel_id)->get();
        echo json_encode($rooms);
    }

    public function setBook(Request $request)
    {
        $day=$request->day;
        $room_id = $request->room;
        echo 'room='.$room_id;
        $find = booking::where('day','=',$day)->where('room_id','=',$room_id)->first();
        if ($find){
            $book=$find;
            $book->delete();
            echo 'del';
        } else {
            $book = new booking;
            $book->room_id = $room_id;
            $book->status = 1;
            $book->day = $day;
            $book->save();
            echo 'save';
        }
    }

    public function getBook(Request $request)
    {
        if (!preg_match('/^\d{4}$/i' , $request->year)) return 'error Year';
        if (!preg_match('/^\d{1,2}$/i' , $request->month)) return 'error month';
        if (!preg_match('/^\d{1,}$/i' , $request->room_id)) return 'error room';
        $year = $request->year;
        $month = $request->month;
        $month++;
        if ($month<10){
            $month='0'.$month;
        }
        $start = $year.'-'.$month.'-01';
        if ($month==11){
            $end = ($year+1).'-01-01';
        } else{
            $month = $month+1;
            if ($month<10){
                $month='0'.$month;
            }
            $end = $year.'-'.$month.'-01';
        }
        $list = booking::where('day','>=',$start)->where('day','<',$end)->where('room_id','=',$request->room_id)->get();
        $book=[];
        for ($i=1; $i <=31 ; $i++) {
            $book[$i] = 0;
            foreach ($list as $l) {
                $day = substr($l->day,8,2);
                if ($day==$i){
                    $book[$i] = $l->status;
                }
            }
        }
        echo json_encode($book);
    }
}

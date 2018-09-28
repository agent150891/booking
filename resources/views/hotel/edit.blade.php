@extends('layouts.general')

@section('content')
<!-- Modal Delete-->
    <div id="modal_delete_hotel" class="modal fade add-hotel" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
        <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4>Ви дійсно бажаєте видалити це оголошення?</h4>
                </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default"  data-dismiss="modal">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
                   &nbsp;&nbsp;&nbsp;Повернутися
                <i class="fa fa-angle-" aria-hidden="true"></i>
             </button>
            <a class="btn btn-default pull-right" href="{{asset('deleteHotel/'.$hotel->id)}}">
                Видалити
            </a>
          </div>
        </div>

      </div>
    </div>
<!-- END MODAL Delete-->

<input type="hidden" id ="hotel_id" value="{{$hotel->id}}">
<main>
    <div class="main_head">
        <ol class="path">
          <li><a href="{{asset('/')}}">Головна</a></li>
          <li><a href="{{asset('/cabinet')}}">Особистий кабінет</a></li>
          <li><a href="{{asset('/cabinet')}}">Оренда житла</a></li>
          <li class="active">{{$hotel->title}}</li>
        </ol>
        <div class="green"></div>
        <div class="grey grey-hotel"></div>
    </div>
    <section class="hotel-edit1 hotel-edit">
        <aside class="hotel-menu">
            <menu>
                <a href="#" class="btn btn-default">Редагувати</a>
                <a href="#" class="btn btn-default">Підняти</a>
                <a href="#" class="btn btn-default">Подовжити</a>
                <a href="#" class="btn btn-default">Розмістити в ТОП</a>
                <a href="#" class="btn btn-default">Зробити ВІП</a>
                <a href="#" class="btn btn-default">Зробити платним</a>
                <a href="{{asset('/hotel/'.$hotel->id.'/feeds')}}" class="btn btn-default">Відгуки</a>
                <a href="#" class="btn btn-default" data-toggle="modal" data-target="#modal_delete_hotel">Видалити</a>
            </menu>
        </aside>
        <aside class="info1">
            <div class="user">
                <h2>{{$user->name}}</h2>
                <ul>
@foreach ($phones as $phone)
    <li>@php
        $p = $phone->phone;
        echo "+";
        echo substr($p, 0, 2);
        echo ' (';
        echo substr($p, 2, 3);
        echo ') ';
        echo substr($p, 5, 2);
        echo '-';
        echo substr($p, 7, 2);
        echo '-';
        echo substr($p, 9, 3);
        @endphp</li>
@endforeach
                </ul>
            </div>
            <!-- <p>
                Додатковий номер телефону
                <a href="#">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </a>
            </p> -->
            <label for="e_title"><small>Назва оголошення</small></label>
            <input type="text" value="{{$hotel->title}}" class="form-control col-xs-12" id="e_title">

            <label class="text" for="e_rooms">Всього номерів</label>
            <input type="text" class="form-control col-xs-1" value="{{$hotel->rooms}}" id="e_rooms">

            <label class="text" for="e_lux">Номерів люкс</label>
            <input type="text" class="form-control col-xs-1" value="{{$hotel->lux}}" id="e_lux">

            <label class="text" for="e_price">Вартість від:</label>
            <input type="text" class="form-control col-xs-1" value="{{$hotel->price}}" id="e_price">
            <small>грн</small>

            <label>
@if ($hotel->pay_type==0)
                <input type="radio" name="epay_type" checked id="e_price_type">
                <div class="check"></div> За номер
            </label>
            <label>
                <input type="radio" name="epay_type">
@else
                <input type="radio" name="epay_type" id="e_price_type">
                <div class="check"></div> За номер
            </label>
            <label>
                <input type="radio" name="epay_type" checked>
@endif
                <div class="check"></div> За ліжкомісце
            </label>
        </aside>
        <aside class="info2">
            <label><small>Оберіть населенний пункт</small>
                <select name="" id="e_city" class="form-control">
@foreach ($cities as $city)
    @if ($city->id==$hotel->city_id)
        <option value="{{$city->id}}" selected="selected">{{$city->city}}</option>
    @else
        <option value="{{$city->id}}">{{$city->city}}</option>
    @endif
@endforeach
                </select>
            </label>
            <label><small>Оберіть вид житла</small>
                <select name="" id="" class="form-control">
@foreach ($htypes as $type)
    @if ($type->id==$hotel->hotel_type_id)
        <option value="{{$type->id}}" selected="selected">{{$type->hotel_type}}</option>
    @else
        <option value="{{$type->id}}">{{$type->hotel_type}}</option>
    @endif
@endforeach
                </select>
            </label>
            <h5><small>Відстань до обїектів</small></h5>
            <label class="text" for="beach">До пляжу</label>
            <input type="text" class="form-control col-xs-1" value="{{$hotel->to_beach}}" id="beach">
            <small>м</small>
            <label class="text" for="shop">До магазину</label>
            <input type="text" class="form-control col-xs-1" value="{{$hotel->to_shop}}" id="shop">
            <small>м</small>
            <label class="text" for="rest">До ресторану</label>
            <input type="text" class="form-control col-xs-1" value="{{$hotel->to_rest}}" id="rest">
            <small>м</small>
            <label class="text" for="disco">До дискотеки</label>
            <input type="text" class="form-control col-xs-1" value="{{$hotel->to_disco}}" id="disco">
            <small>м</small>
            <label class="text" for="bus">До зупинки</label>
            <input type="text" class="form-control col-xs-1" value="{{$hotel->to_bus}}" id="bus">
            <small>м</small>
        </aside>
        <aside class="map">
            <div class="map">
                <div id="map_hotel"></div>
                <input type="text" class="form-control" value="{{$hotel->address}}" id="e_address">
            </div>
            <small>Введіть точну адресу</small>
        </aside>
    </section>
    <section class="hotel-photos hotel-edit">
        <aside class="photos">
            <h3>Зображення оголошення</h3>
            <h5><small>Максимальний розмір файла 2 МБ</small></h5>
            <ul id="edit_photos">
                <li>
@if ($hotel->foto1!='')
    <img src="{{'/storage/app/'.$hotel->foto1}}" alt="hotel photo">
    <i class="fa fa-trash-o" aria-hidden="true"></i>
@endif
                </li>
                <li>
@if ($hotel->foto2!='')
    <img src="{{'/storage/app/'.$hotel->foto2}}" alt="hotel photo">
    <i class="fa fa-trash-o" aria-hidden="true"></i>
@endif
                </li>
                <li>
                    @if ($hotel->foto3!='')
                        <img src="{{'/storage/app/'.$hotel->foto3}}" alt="hotel photo">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    @endif
                </li>
                <li>
                    @if ($hotel->foto4!='')
                        <img src="{{'/storage/app/'.$hotel->foto4}}" alt="hotel photo">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    @endif
                </li>
                <li>
                    @if ($hotel->foto5!='')
                        <img src="{{'/storage/app/'.$hotel->foto5}}" alt="hotel photo">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    @endif
                </li>
            </ul>
            <h5><small>Потрібно завантажити минимум 1 зображення</small></h5>
        </aside>
        <aside class="menu">
            <menu>
                <a href="#" class="btn btn-default" id="add_photo">Додати фото</a>
                <a href="#" class="btn btn-default"  id="del_photo">Видалити фото</a>
                <input type="file" name="load_hotel_photo" accept="image/*" id="load_hotel_photo" class="hidden">
            </menu>
        </aside>
    </section>
    <section class="hotel-edit hotel-feaches">
        На теріторіі:
        <label class="check">
@if ($hotel->parking>0)
    <input type="checkbox" checked="ckecked" id="e_parking"><span></span>
@else
    <input type="checkbox" id="e_parking"><span></span>
@endif
            Стоянка
        </label>
        <label class="check">
            @if ($hotel->wifi>0)
                <input type="checkbox" checked="ckecked" id="e_wifi"><span></span>
            @else
                <input type="checkbox" id="e_wifi"><span></span>
            @endif
            WI-FI
        </label>
        <label class="check">
            @if ($hotel->altan>0)
                <input type="checkbox" checked="ckecked" id="e_altan"><span></span>
            @else
                <input type="checkbox" id="e_altan"><span></span>
            @endif
            Альтанки
        </label>
        <label class="check">
            @if ($hotel->kids>0)
                <input type="checkbox" checked="ckecked" id="e_kids"><span></span>
            @else
                <input type="checkbox" id="e_kids"><span></span>
            @endif
            Дитячий майданчик
        </label>
        <label class="check">
            @if ($hotel->kitchen>0)
                <input type="checkbox" checked="ckecked" id="e_kitchen"><span></span>
            @else
                <input type="checkbox" id="e_kitchen"><span></span>
            @endif
            Кухня
        </label>
        <span class="space"></span>
        Душ/туалет:&nbsp;&nbsp;&nbsp;
        <label>
@if ($hotel->bath==0)
            <input type="radio" name="ewc_type" checked id="e_wc_type">
            <div class="check"></div> В номері
        </label>
        <label>
            <input type="radio" name="ewc_type">
@else
            <input type="radio" name="ewc_type">
            <div class="check"></div> В номері
        </label>
        <label>
            <input type="radio" name="ewc_type" checked>
@endif

            <div class="check"></div> Загальний
        </label>
    </section>
    <section class="hotel-edit hotel-about">
        <aside class="about">
            <textarea id="e_about">{{$hotel->about}}</textarea>
        </aside>
        <aside class="menu">
            <menu>
                <a href="{{asset('/roomsedit/'.$hotel->id)}}" class="btn btn-default">Керування номерами</a>
                <a href="#" class="btn btn-default" id="save_hotel_edit">Зберігти зміни</a>
                <p>Дійсне до <span>{{substr($hotel->date_out,0,10)}}</span></p>
            </menu>
        </aside>
    </section>
</main>
<script>
var map_hotel;
var map;
function initMap() {
  map_hotel = new google.maps.Map(document.getElementById('map_hotel'), {
    center: {lat: {{$hotel->gps_lng}} , lng: {{$hotel->gps_alt}} },
    zoom: 13,
});
    map = new google.maps.Map(document.getElementById('add_map'), {
      center: {lat: 51.496839, lng: 23.930185},
      zoom: 12
    });
}
</script>
<script>
var baseUrl='../../';
</script>
<script src="../../js/edit_hotel.js"></script>
@endsection

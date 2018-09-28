@extends('layouts.general')

@section('content')
<input type="hidden" id ="hotel_id" value="{{$rooms[0]->hotel_id}}">
<main>
    <div class="main_head">
        <ol class="path">
          <li><a href="{{asset('/')}}">Головна</a></li>
          <li><a href="{{asset('cabinet')}}">Особистий кабінет</a></li>
          <li><a href="{{asset('cabinet')}}">Оренда житла</a></li>
          <li><a href="{{asset('hotel/'.$hotel->id.'/edit')}}">{{$hotel->title}}</a></li>
          <li class="active">Номери</li>
        </ol>
        <div class="green"></div>
        <div class="grey grey-hotel"></div>
    </div>
    <section class="room-edit">
        <aside class="room-list">
            <h1>Перелік Ваших номерів</h1>
            <ul>
@php
    $first = true;
    $i=0;
@endphp
@foreach($rooms as $room)
    @if ($first)
    @php
        $first = false;
        echo '<li class="active">';
        echo '<input type="hidden" value="'.($i++).'" name="number">';
        echo $room->title;
        echo '</li>';
    @endphp
    @else
        <li>
            <input type="hidden" value="{{$i++}}" name="number">
            {{$room->title}}
        </li>
    @endif
@endforeach
            </ul>
        </aside>
        <aside class="room-info">
            <label class="small">
                Назва номера або порядковий номер
                <input type="text" value="{{$rooms[0]->title}}" id="e_title">
            </label>
            <label class="big">
                Вартість за добу:
                <input type="text" value="{{$rooms[0]->price}}" id="e_price">
                <small>грн</small>
            </label>
            <label class="medium">
@if ($hotel->pay_type==0)
                <input type="radio" name="pay_type" checked id="e_price_type">
                <div class="check"></div> За номер
            </label>
            <label class="medium">
                <input type="radio" name="pay_type" id="e_price_type1">
@else
                <input type="radio" name="pay_type"  id="e_price_type">
                <div class="check"></div> За номер
            </label>
            <label class="medium">
                <input type="radio" name="pay_type" checked id="e_price_type1">
@endif
                <div class="check"></div> За ліжкомісце
            </label>
            <label class="small">
                Кількість спальних місць
                <select id="e_beds">
@for($i=1;$i<9;$i++)
    @if($rooms[0]->beds == $i)
        <option value="{{$i}}" selected="selected">{{$i}}</option>
    @else
        <option value="{{$i}}">{{$i}}</option>
    @endif
@endfor
                </select>
            </label>
        </aside>
        <aside class="booking">
            <h2>У календарі ви можете відзначити  заброньовані дати</h2>
            <!-- календарь бронирования -->
            <div id="booking">
                <table>
                <thead>
                    <tr>
                        <th>Пн</th>
                        <th>Вт</th>
                        <th>Ср</th>
                        <th>Чт</th>
                        <th>Пт</th>
                        <th>Сб</th>
                        <th>Нд</th>
                    </tr>
                </thead>
                    <tbody></tbody>
                </table>
            </div>
        </aside>
        <aside class="features">
            <h3>В номері є</h3>
            <label class="check">
@if ($rooms[0]->wc>0)
    <input type="checkbox" checked id="e_wc"><span></span>
@else
    <input type="checkbox" id="e_wc"><span></span>
@endif
                Туалет
            </label>
            <label class="check">
                @if ($rooms[0]->bath>0)
                    <input type="checkbox" checked id="e_bath"><span></span>
                @else
                    <input type="checkbox" id="e_bath"><span></span>
                @endif
                Душ
            </label>
            <label class="check">
                @if ($rooms[0]->tv>0)
                    <input type="checkbox" checked id="e_tv"><span></span>
                @else
                    <input type="checkbox" id="e_tv"><span></span>
                @endif
                Телевізор
            </label>
            <label class="check">
                @if ($rooms[0]->cond>0)
                    <input type="checkbox" checked id="e_cond"><span></span>
                @else
                    <input type="checkbox" id="e_cond"><span></span>
                @endif
                Кондіціонер
            </label>
            <label class="check">
                @if ($rooms[0]->holo>0)
                    <input type="checkbox" checked id="e_holo"><span></span>
                @else
                    <input type="checkbox" id="e_holo"><span></span>
                @endif
                Холодильник
            </label>
            <label class="check">
                @if ($rooms[0]->kitchen>0)
                    <input type="checkbox" checked id="e_kitchen"><span></span>
                @else
                    <input type="checkbox" id="e_kitchen"><span></span>
                @endif
                Кухня
            </label>
            <textarea id="e_about">{{$rooms[0]->about}}</textarea>
        </aside>
    </section>
    <section class="room-photos">
        <h2>Зображення оголошення</h2>
        <p>Потрібно завантажити минимум 1 зображення</p>

        @if ($rooms[0]->foto1!='')
            <div>
                <img src="{{'/storage/app/'.$rooms[0]->foto1}}" alt="room photo">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
            </div>
        @endif
        @if ($rooms[0]->foto2!='')
            <div>
                <img src="{{'/storage/app/'.$rooms[0]->foto2}}" alt="room photo">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
            </div>
        @endif
        @if ($rooms[0]->foto3!='')
            <div>
                <img src="{{'/storage/app/'.$rooms[0]->foto3}}" alt="room photo">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
            </div>
        @endif
        @if ($rooms[0]->foto4!='')
            <div>
                <img src="{{'/storage/app/'.$rooms[0]->foto4}}" alt="room photo">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
            </div>
        @endif
        @if ($rooms[0]->foto5!='')
            <div>
                <img src="{{'/storage/app/'.$rooms[0]->foto5}}" alt="room photo">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
            </div>
            @endif
        @if ($rooms[0]->foto6!='')
            <div>
                <img src="{{'/storage/app/'.$rooms[0]->foto6}}" alt="room photo">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
            </div>
        @endif
        <menu>
        <p>Максимальний розмір файла 2 МБ</p>
        <a href="#" class="btn btn-default" id="add_rphoto">Додати фото</a>
        <a href="#" class="btn btn-default" id="del_photo">Видалити фото</a>
        <input type="file" name="load_room_photo" accept="image/*" id="load_room_photo" class="hidden">
        </menu>
    </section>
    <section class="room-save">
        <a href="#" class="btn btn-default" id="save">Зберегти зміни</a>
    </section>
</main>

<script>
var map_hotel;
var map;
function initMap() {
      map = new google.maps.Map(document.getElementById('add_map'), {
      center: {lat: 51.496839, lng: 23.930185},
      zoom: 12
    });
}
</script>
<script>
var baseUrl='../';
</script>
<script src="{{asset('/js/rooms_edit.js')}}"></script>
@endsection

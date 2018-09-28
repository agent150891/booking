@extends('layouts.general')

@section('content')
@php
function setphone($phone){
    $p='+';
    $p .= substr($phone, 0, 2);
    $p .= ' (';
    $p .= substr($phone, 2, 3);
    $p .= ') ';
    $p .= substr($phone, 5, 3);
    $p .= '-';
    $p .= substr($phone, 8, 2);
    $p .= '-';
    $p .= substr($phone, 10, 2);
    return $p;
};
@endphp
<main>
    <div class="main_head">
        <ol class="path">
          <li><a href="{{asset('/')}}">Головна</a></li>
          <li><a href="{{asset('/cabinet')}}">Особистий кабінет</a></li>
          <li class="active">Мої оголошення</li>
        </ol>
        <div class="green greenf"></div>
        <div class="grey grey-hotel greyf"></div>
    </div>
    <section class="user-info">
        <h2 class="small">Ваші данні</h2>
        <form id="user_data">
            <input type="text" placeholder="Ім'я" value="{{$user->name}}" id="change_name" name="change_user_name">
            <p>{{setphone($phones[0]->phone)}}
            </p>
            @php
            $fist_phone = true;
            foreach($phones as $phone)
            if ($fist_phone){
                $fist_phone = false;
                $i=0;
            } else{
                $i++;
                $pp = '+';
                $p = $phone->phone;
                $pp .= substr($p, 0, 2);
                $pp .= ' (';
                $pp .= substr($p, 2, 3);
                $pp .= ') ';
                $pp .= substr($p, 5, 3);
                $pp .= '-';
                $pp .= substr($p, 8, 2);
                $pp .= '-';
                $pp .= substr($p, 10, 2);
                echo '<input type="text" placeholder="+38 (000) 000-00-00" value="'.$pp.'" name="phones[]" id="phone'.$i.'">';
            }
            @endphp
        </form>
        <a href="#" id="add_other_phone">Додатковий номер телефону
            <i class="fa fa-plus" aria-hidden="true"></i>
        </a>
        <button type="button" name="button" class="btn btn-default" id="save_user_info">Зберегти</button>
    </section>
    <section class="adds-list">
        <ul class="caption">
			<li>Всі Ваші оголошення</li>
			<li>Статус</li>
            <li>Рубрика</li>
		</ul>
        @foreach($hotels as $hotel)
        <aside class="add">
            <div>
                {{$hotel->title}}
            </div>
            <div>
                @if (strtotime($hotel->date_out)>time())
                    Активне
                @else
                    Неактивне
                @endif
            </div>
            <div>
                Оренда житла
            </div>
            <a href="{{asset('hotel/'.$hotel->id.'/edit')}}" class="btn btn-default">Редагувати</a>
        </aside>
        @endforeach
    </section>
</main>
<script>
var map;
function initMap() {
    map = new google.maps.Map(document.getElementById('add_map'), {
      center: {lat: 51.496839, lng: 23.930185},
      zoom: 12
    });
}
</script>
<script>
var baseUrl='';
</script>
<script src="js/cabinet.js"></script>
@endsection

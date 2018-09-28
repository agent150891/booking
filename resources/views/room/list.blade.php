@extends('layouts.general')

@section('content')
<main>
    <div class="main_head">
        <ol class="path right">
          <li><a href="{{asset('/')}}">Головна</a></li>
          <li><a href="#">Оголошення</a></li>
          <li><a href="#">Оренда житла</a></li>
          <li><a href="{{asset('/hotel/'.$hotel->id)}}">{{$hotel->title}}</a></li>
          <input type="hidden" id="hotel_id" value="{{$hotel->id}}">
          <input type="hidden" id="phone" value="
          @php
          $p = $phone->phone;
          echo substr($p, 0, 2);
          echo ' (';
          echo substr($p, 2, 3);
          echo ') ';
          echo substr($p, 5, 3);
          echo '-';
          echo substr($p, 8, 2);
          echo '-';
          echo substr($p, 10, 2);
          @endphp
          ">
          <li class="active">Всі номера</li>
        </ol>
    <h1>Номера {{$hotel->title}}</h1>
    </div>
    <div class="green rooms-line1"></div>
    <div class="grey rooms-line2"></div>
    <div class="main">
        <section class="rooms" id="room_list">
@foreach($rooms['list'] as $room)
            <aside>
                <div class="photo">
                    <a href="{{asset('/room/'.$room->id)}}">
                        <img src="{{'/storage/app/'.$room->foto1}}" alt="room_photo">
                    </a>
                    <img src="../img/images.png" alt="images" class="images">
                </div>
                <div class="content">
                    <h3>{{$room->title}}</h3>
                    <div>
                        <ul>
                            <li>
                                <img src="../img/bed.png" alt="bed">
                                <div class="info-bed">
                                    Кількість спальних місць
                                </div>
                                <span>{{$room->beds}}</span>
                            </li>
                            <li>
                                <img src="../img/wi-fi.png" alt="wifi">
                                <div class="info-wifi">
                                    WI-FI
                                </div>
                                <span>
                                    @if($room->wifi==1)
                                        Так
                                    @else
                                        Ні
                                    @endif
                                </span>
                            </li>
                            <li>
                                <img src="../img/bath.png" alt="bath">
                                <div class="info-bath">
                                    Душ у номері
                                </div>
                                <span>
                                    @if($room->bath==1)
                                        Так
                                    @else
                                        Ні
                                    @endif
                                </span>
                            </li>
                            <li>
                                <img src="../img/wc.png" alt="wc">
                                <div class="info-wc">
                                    Туалет у номері
                                </div>
                                <span>
                                    @if($room->wc==1)
                                        Так
                                    @else
                                        Ні
                                    @endif
                                </span>
                            </li>
                            <li>
                                <img src="../img/cond.png" alt="cond">
                                <div class="info-cond">
                                    Кондіціонер
                                </div>
                                <span>
                                    @if($room->cond==1)
                                        Так
                                    @else
                                        Ні
                                    @endif
                                </span>
                            </li>
                            <li>
                                <img src="../img/tv.png" alt="tv">
                                <div class="info-tv">
                                    Телевізор
                                </div>
                                <span>
                                    @if($room->tv==1)
                                        Так
                                    @else
                                        Ні
                                    @endif
                                </span>
                            </li>
                            <li>
                                <img src="../img/kitchen.png" alt="kitchen">
                                <div class="info-kitchen">
                                    Кухня
                                </div>
                                <span>
                                    @if($room->kitchen==1)
                                        Так
                                    @else
                                        Ні
                                    @endif
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <img src="../img/phone.png" alt="phone">
                        <span class="phone">
                            @php
                            $p = $phone->phone;
                            echo substr($p, 0, 2);
                            echo ' (';
                            echo substr($p, 2, 3);
                            echo ') ';
                            echo substr($p, 5, 3);
                            echo '-';
                            echo substr($p, 8, 2);
                            echo '-';
                            echo substr($p, 10, 2);
                            @endphp
                        </span>
                    </div>
                    <article>{{$room->about}}</article>

                    <div class="grey"></div>
                    <div class="details">
                        від <span>{{$room->price}}</span> грн/доба
                        <a href="{{asset('/room/'.$room->id)}}" class="btn btn-success pull-right">Детальніше</a>
                    </div>
                </div>
            </aside>
@endforeach
            @php
                echo $rooms['pagg'];
            @endphp
        </section>
        <section class="banners">
            <img src="../img/banner.jpg">
        </section>
    </div>
</main>

<section class="history">
    @if (count($visits)>0)
        <h2>Ви переглядали</h2>
        <div class="green"></div>
        <div class="grey"></div>
    @endif

        @foreach ($visits as $visit)
        <aside>
                <div class="main-photo">
                        <img src="/storage/app/{{$visit['foto']}}" alt="visited">
                </div>
                <div class="content">
                        <h3>{{$visit['title']}}</h3>
                        <div class="grey"></div>
                        <p>
                        <span>{{$visit['price']}}</span> {{$visit['price_type']}}
                                <a href="{{asset($visit['link'])}}" class="pull-right">Детальніше
                                        <img src="../img/arrow.svg" alt='->'>
                                </a>
                        </p>
                </div>
        </aside>
        @endforeach
</section>
<script src="{{asset('/js/room_list.js')}}"></script>
<script>
var baseUrl='../';
</script>
@endsection

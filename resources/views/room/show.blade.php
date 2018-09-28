@extends('layouts.general')

@section('content')
<main>
    <div class="main_head">
        <ol class="path">
          <li><a href="{{asset('/')}}">Головна</a></li>
          <li><a href="#">Оголошення</a></li>
          <li><a href="#">Оренда житла</a></li>
          <li><a href="{{asset('/hotel/'.$hotel->id)}}">{{$hotel->title}}</a></li>
          <li><a href="{{asset('/rooms/'.$hotel->id)}}">Всі номера</a></li>
          <li class="active">{{$room->title}}</li>
        </ol>
        <div class="green"></div>
        <div class="grey grey-hotel"></div>
    </div>
    </div>
        <section class="hotel-view">
            <aside class="room-info">
                <a data-fancybox="gallery" href="{{'/storage/app/'.$room->foto1}}">
                    <img src="{{'/storage/app/'.$room->foto1}}" alt="головне фото" class="main-photo">
                </a>
                <h1>
                    @if(strtotime($hotel->date_vip) > time())
                    <span class="VIP">VIP</span>
                    @endif
                    @if(strtotime($hotel->date_top) > time())
                    <span class="TOP">TOP</span>
                    @endif
                    {{$room->title}}</h1>
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
                    <article>
                        {{$room->about}}
                    </article>
                </div>
            </aside>
        </section>
        <section class="actions">
            <aside class="photos">
            @if($room->foto2!="")
                <div class="photo left">
                    <a data-fancybox="gallery" href="{{'/storage/app/'.$room->foto2}}">
                        <img src="{{'/storage/app/'.$room->foto2}}" alt="hotel photo">
                    </a>
                </div>
            @endif
            @if($room->foto3!="")
                <div class="photo right">
                    <a data-fancybox="gallery" href="{{'/storage/app/'.$room->foto3}}">
                        <img src="{{'/storage/app/'.$room->foto3}}" alt="hotel photo">
                    </a>
                </div>
            @endif
            @if($room->foto4!="")
                <div class="photo left">
                    <a data-fancybox="gallery" href="{{'/storage/app/'.$room->foto4}}">
                        <img src="{{'/storage/app/'.$room->foto4}}" alt="hotel photo">
                    </a>
                </div>
            @endif
            @if($room->foto5!="")
                <div class="photo right">
                    <a data-fancybox="gallery" href="{{'/storage/app/'.$room->foto5}}">
                        <img src="{{'/storage/app/'.$room->foto5}}" alt="hotel photo">
                    </a>
                </div>
            @endif

            </aside>
            <p>від <span>{{$room->price}}</span> грн/доба</p>
            <a href="#" class="btn btn-success">Керування оголошенням</a>
            <div class="phone">
                <h3>{{$user->name}}</h4>
                <h4>{{$hotel_city->city}}</h5>
                <p>
                    <i class="fa fa-phone" aria-hidden="true"></i>
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
                </p>
            </div>
        </section>
        <section class="banners">
            <img src="../img/banner.jpg">
        </section>
    </div>
</main>

<script>
var baseUrl='../';
</script>
@endsection

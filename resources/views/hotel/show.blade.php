@extends('layouts.general')

@section('content')
<main>
    <div class="main_head">
        <ol class="path">
          <li><a href="{{asset('/')}}">Головна</a></li>
          <li><a href="{{asset('cabinet')}}">Оголошення</a></li>
          <li><a href="{{asset('cabinet')}}">Оренда житла</a></li>
          <li class="active">{{$hotel->title}}</li>
        </ol>
        <div class="green"></div>
        <div class="grey grey-hotel"></div>
    </div>
    </div>
        <section class="hotel-view">
            <aside class="hotel-info">
                <a data-fancybox="gallery" href="{{'/storage/app/'.$hotel->foto1}}">
                    <img src="{{'/storage/app/'.$hotel->foto1}}" alt="головне фото" class="main-photo">
                </a>
                <h1>
                    @if(strtotime($hotel->date_vip) > time())
                    <span class="VIP">VIP</span>
                    @endif
                    @if(strtotime($hotel->date_top) > time())
                    <span class="TOP">TOP</span>
                    @endif
                    {{$hotel->title}}</h1>
                <ul>
                    <li class="big">
                        <img src="../img/beach.png" alt="beach">
                        <div>відстань до пляжу</div>
                        <span>
                        @if ($hotel->to_beach>=500)
                            {{round($hotel->to_beach/1000,1)}} </span> км до пляжу
                        @else
                            {{$hotel->to_beach}} </span> м до пляжу
                        @endif
                    </li>
                    <li class="big">
                        <img src="../img/home.png" alt="home">
                        <div>всього номерів</div>
                        <span>{{$hotel->rooms}}</span> кімнат всього
                    </li>
                    <li class="big">
                        <img src="../img/lux.png" alt="lux">
                        <div>номерів Люкс</div>
                        <span>{{$hotel->lux}}</span> номери Люкс
                    </li>
                    <li class="big">
                        <img src="../img/beach.png" alt="shop">
                        <div>відстань до магазину</div>
                        <span>
                        @if ($hotel->to_shop>=500)
                            {{round($hotel->to_shop/1000,1)}} </span> км до магазину
                        @else
                            {{$hotel->to_shop}} </span> м до магазину
                        @endif
                    </li>
                    <li class="big">
                        <img src="../img/beach.png" alt="rest">
                        <div>відстань до ресторану</div>
                        <span>
                        @if ($hotel->to_rest>=500)
                            {{round($hotel->to_rest/1000,1)}} </span> км до ресторану
                        @else
                            {{$hotel->to_rest}} </span> м до ресторану
                        @endif
                    </li>
                    <li class="big">
                        <img src="../img/beach.png" alt="disco">
                        <div>відстань до дискотеки</div>
                        <span>
                        @if ($hotel->to_disco>=500)
                            {{round($hotel->to_disco/1000,1)}} </span> км до дискотеки
                        @else
                            {{$hotel->to_disco}} </span> м до дискотеки
                        @endif
                    </li>
                    <li class="big">
                        <img src="../img/beach.png" alt="bus">
                        <div>відстань до зупинки</div>
                        <span>
                        @if ($hotel->to_bus>=500)
                            {{round($hotel->to_bus/1000,1)}} </span> км до зупинки
                        @else
                            {{$hotel->to_bus}} </span> м до зупинки
                        @endif
                    </li>
                    <li class="big">
                        <img src="../img/bath.png" alt="bath">
                        <div>Туалет/душ</div>
                        <span>
                            @if ($hotel->bath == 1)
                                Загальний
                            @else
                                У номері
                            @endif
                        </span>
                    </li>
                </ul>
                <ul>
                    <li class="small">
                        <img src="../img/parking.png" alt="parking">
                        <div>Паркінг</div>
                        <span>
                            @if($hotel->parking==1)
                                Так
                            @else
                                Ні
                            @endif
                        </span>
                    </li>
                    <li class="small">
                        <img src="../img/altan.png" alt="altanka">
                        <div>Альтанка</div>
                        <span>
                            @if($hotel->altan==1)
                                Так
                            @else
                                Ні
                            @endif
                        </span>
                    </li>
                    <li class="small">
                        <img src="../img/kids.png" alt="kids">
                        <div>Дитячий майданчик</div>
                        <span>
                            @if($hotel->kids==1)
                                Так
                            @else
                                Ні
                            @endif
                        </span>
                    </li>
                    <li class="small">
                        <img src="../img/kitchen.png" alt="kitchen">
                        <div>Кухня</div>
                        <span>
                            @if($hotel->kitchen==1)
                                Так
                            @else
                                Ні
                            @endif
                        </span>
                    </li>
                </ul>
                    <article>
                        {{$hotel->about}}
                    </article>
                    @if (session('user_id')!=$hotel->user_id)
                    <form action="#" id="feed_form">
                        <h2>Залишити відгук</h2>
                        <h3>Оберить тип відгуку
                            <label>
                                <input type="radio" name="reight" checked id="reight">
                                <div class="check"></div> Позитивний
                            </label>
                            <label>
                                <input type="radio" name="reight">
                                <div class="check"></div> Негативний
                            </label>
                        </h3>
                        <input type="text" placeholder="Введіть ім'я" name="name" id="form_name">
                        <input type="text" placeholder="Введіть телефон" name="tel" id="form_tel">
                        <input type="hidden" value="{{$hotel->id}}" id="hotel_id">
                        <textarea name="form_text" id="form_text">    Текст повідомлення</textarea>
                        <input type="text" placeholder="Код з СМС" name="code_feed" id="code_feed" class="hidden">
                        <input type="submit" value="Перевірити" class="btn btn-warning hidden" id="code_but">
                        <input type="submit" value="Відправити" class="btn btn-info btn-sm" id="send_feed">
                    </form>
                    @endif

                </div>
            </aside>
            <div id="alert-block">
            </div>
            <aside class="feeds">
                <h2>Відгуки</h2>
                @php
                    $plus=0;
                    $minus=0;
                    foreach($feeds as $feed){
                        if ($feed->reight==1){
                            $plus++;
                        }
                        if ($feed->reight==-1){
                            $minus++;
                        }
                    }
                @endphp
                <span class="plus"></span><span id="reight_plus">
                    {{$plus}}
                </span>
                <span class="minus"></span><span id="reight_minus">{{$minus}}</span>
                @foreach ($feeds as $feed)
                    @if ($feed->reight==0)
                        <div class="feed feed-re">
                    @else
                        <div class="feed">
                    @endif

                        <h3>
                            @if ($feed->reight>0)
                                <span class="plus"></span>
                            @elseif ($feed->reight<0)
                                <span class="minus"></span>
                            @else
                                <span class="re"></span>
                            @endif
                            {{$feed->name}}
                            <span class="date">{{substr($feed->created_at,8,2).'.'.substr($feed->created_at,5,2).'.'.substr($feed->created_at,0,4)}}</span>
                        </h3>
                        <p>{{$feed->comment}}</p>
                        <a href="#">Ще</a>
                    </div>
                    @if($feed->feed_id>0)
                        <div class="feed feed-re">
                            <h3><span class="re"></span>{{$feed->rname}}</h3>
                            <p>{{$feed->re}}</p>
                        </div>
                    @endif
                @endforeach
                @if (Count($feeds)>1)
                    <button class="btn btn-info" id="all_feeds">Ще відгуки</button>
                @else
                    <button class="btn btn-info hidden" id="all_feeds">Ще відгуки</button>
                @endif
            </aside>
        </section>
        <section class="actions">
            <aside class="photos">

                @if($hotel->foto2!="")
                    <div class="photo left">
                        <a data-fancybox="gallery" href="{{'/storage/app/'.$hotel->foto2}}">
                            <img src="{{'/storage/app/'.$hotel->foto2}}" alt="hotel photo">
                        </a>
                    </div>
                @endif
                @if($hotel->foto3!="")
                    <div class="photo right">
                        <a data-fancybox="gallery" href="{{'/storage/app/'.$hotel->foto3}}">
                            <img src="{{'/storage/app/'.$hotel->foto3}}" alt="hotel photo">
                        </a>
                    </div>
                @endif
                @if($hotel->foto4!="")
                    <div class="photo left">
                        <a data-fancybox="gallery" href="{{'/storage/app/'.$hotel->foto4}}">
                            <img src="{{'/storage/app/'.$hotel->foto4}}" alt="hotel photo">
                        </a>
                    </div>
                @endif
                @if($hotel->foto5!="")
                    <div class="photo right">
                        <a data-fancybox="gallery" href="{{'/storage/app/'.$hotel->foto5}}">
                            <img src="{{'/storage/app/'.$hotel->foto5}}" alt="hotel photo">
                        </a>
                    </div>
                @endif

            </aside>
            <p>від <span>{{$hotel->price}}</span> грн/доба</p>
            @if (session('user_id'))
            <a href="{{asset('cabinet')}}" class="btn btn-success">Керування оголошенням</a>
            @endif
            <a href="{{asset('/rooms/'.$hotel->id)}}" class="btn btn-warning">Переглянути номери</a>
            <div class="phone">
                <h3>{{$user->name}}</h4>
                <h4>{{$hotel_city->city}}</h5>
                <p>
                    <i class="fa fa-phone" aria-hidden="true"></i>
                    @php
                    $p = $phone->phone;
                    echo '+';
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
            <div class="map">
                <div style="width:268px;height:220px" id="map_hotel"></div>
                <p>
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                    {{$hotel->address}}
                </p>
            </div>
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
<script>
var map_hotel;
function initMap() {
  map_hotel = new google.maps.Map(document.getElementById('map_hotel'), {
    center: {lat: {{$hotel->gps_lng}} , lng: {{$hotel->gps_alt}} },
    zoom: 13,
    draggable: false
  });
  map = new google.maps.Map(document.getElementById('add_map'), {
    center: {lat: 51.496839, lng: 23.930185},
    zoom: 12
  });
}
</script>
<script>
var baseUrl='../';
</script>
<script src="../js/hotel.js"></script>
@endsection

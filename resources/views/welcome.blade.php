@extends('layouts.general')

@section('content')

  <div class="slider">
        <dialog open>
                <form>
                <div class="filter filter1">
                        <label>
                                Населений пункт:
                                <select class="form-control input-sm" id="city_id">
                                    <option value="0">Оберіть місто</option>
                                    @foreach($cities as $city)
                                        <option value="{{$city['id']}}">{{$city['city']}}</option>
                                    @endforeach
                                </select>
                        </label>
                        <label>
                                Вид житла:
                                <select class="form-control input-sm" id="hotel_type_id">
                                    <option value="0">Оберіть тип житла</option>
                                    @foreach($htypes as $htype)
                                        <option value="{{$htype['id']}}">{{$htype['hotel_type']}}</option>
                                    @endforeach
                                </select>
                        </label>
                </div>
                <div class="stick"></div>
                <div  class="filter filter2">
                        <label>
                                Кількість ліжок:
                                <select class="form-control input-sm" id="beds">
                                        <option value="0">Оберіть кількість</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                </select>
                        </label>
                        <div class="check">
                                <label class="check" for="reight">Фільтрувати за <br>рейтингом:
                                <input type="checkbox" name="" id="reight"><span></span></label>
                        </div>
                </div>
                <div class="stick"></div>
                <div  class="filter filter3">
                        <div class="check">
                                <label for="bath">Душ
                                <input type="checkbox" name="" id="bath"><span></span>
                                </label>
                        </div>
                        <div class="check">
                                <label for="wc">Туалет
                                <input type="checkbox" name="" id="wc"><span></span>
                                </label>

                        </div>
                        <div class="check">
                                <label for="cond">Кондиціонер
                                <input type="checkbox" name="" id="cond"><span></span>
                                </label>
                        </div>
                        <div class="check">
                                <label for="tv">Телевізор
                                <input type="checkbox" name="" id="tv"><span></span>
                                </label>
                        </div>
                        <div class="check">
                                <label for="wifi">Wi-fi
                                <input type="checkbox" name="" id="wifi"><span></span>
                                </label>
                        </div>
                        <div class="check">
                                <label for="kitchen">Кухня
                                <input type="checkbox" name="" id="kitchen"><span></span>
                                </label>
                        </div>
                </div>
                <div class="stick"></div>
                <div class="filter filter4">
                        <h3>Кількість результатів</h3>
                        <h2 id="count_filter">0</h2>
                        <button class="btn btn-success" id="filter_but">Шукати</button>
                </div>
                </form>
        </dialog>
        <button>Шукати інші оголошення</button>
</div>
<main>
        <div class="main_head">
        <h1>Оренда житла</h1>
                <form>
                        <select name="" id="sort" class="form-control input-sm">
                                <option value="0">Сортувати</option>
                                <option value="1">Спочатку дешевші</option>
                                <option value="2">Спочатку дорожчі</option>
                        </select>
                </form>
        </div>
        <div class="green"></div>
                <div class="grey"></div>
        <div>
                <section class="book-adds" id="hotel_list">
@foreach($hotels['list'] as $hotel)
<aside>
        <div class="photo">
                <a href="hotel/{{$hotel->id}}">
                    <img src="/storage/app/{{$hotel->foto1}}" alt="hotel_photo">
                </a>
                <img src="img/images.png" alt="images" class="images">
        @if (strtotime($hotel->date_vip)>time())
                <div class="vip"></div>
        @endif
        @if (strtotime($hotel->date_top)>time())
                <div class="top"></div>
        @endif
        </div>
        <div class="content">
                <h3>{{$hotel->title}}</h3>
                <div>
                    <ul>
                        <li>
                            <img src="img/beach.png" alt="beach">
                            <div class="info-beach">
                                    Відстань до пляжу
                            </div>
                            <span>
                                @if ($hotel->to_beach>=500)
                                    {{round($hotel->to_beach/1000,1)}} </span> км до пляжу
                                @else
                                    {{$hotel->to_beach}} </span> м до пляжу
                                @endif
                        </li>
                        <li>
                            <img src="img/home.png" alt="home">
                            <div class="info-rooms">
                                    всього номерів
                            </div>
                            <span>{{$hotel->rooms}}</span> кімнат
                        </li>
                        <li>
                            <img src="img/lux.png" alt="bath">
                            <div class="info-lux">
                                    номерів Люкс
                            </div>
                            <span>{{$hotel->lux}}</span> номерів Люкс
                        </li>
                    </ul>
                </div>
                <div>
                        <img src="img/marker.png" alt="marker">
                        <span>{{$hotel->address}}</span>
                </div>
                <div>
                        <img src="img/phone.png" alt="phone">
                        <span class="phone">+
                            @php
                            echo substr($hotel->phone, 0, 2);
                            echo ' (';
                            echo substr($hotel->phone, 2, 3);
                            echo ') ';
                            echo substr($hotel->phone, 5, 3);
                            echo '-';
                            echo substr($hotel->phone, 8, 2);
                            echo '-';
                            echo substr($hotel->phone, 10, 2);
                            @endphp
                        </span>
                </div>
                <article>{{$hotel->about}}</article>

                <div class="grey"></div>
                <div class="details">
                        від <span>{{$hotel->price}}</span> грн/доба
                        <a href="hotel/{{$hotel->id}}" class="btn btn-success pull-right">Детальніше</a>
                </div>
        </div>
</aside>
@endforeach
@php echo $hotels['pagg']; @endphp

                </section>
                <section class="banners">
                        <img src="img/banner.jpg">
                </section>
        </div>
</main>
<section class="other">
                <h2>Інші оголошення</h2>
                <div class="green"></div>
                <div class="grey"></div>
                <aside>
                        <div class="main-photo">
                                <img src="img/other1.jpg" alt="">
                        </div>
                        <div class="content">
                                <h3>Продам будинок</h3>
                                <div class="grey"></div>
                                <p>
                                <span>250000</span> грн.
                                        <a href="#" class="pull-right">Детальніше
                                                <img src="img/arrow.svg" alt='->'>
                                        </a>
                                </p>
                        </div>
                </aside>
                <aside>
                        <div class="main-photo">
                                <img src="img/other2.jpg" alt="">
                        </div>
                        <div class="content">
                                <h3>Продам козу</h3>
                                <div class="grey"></div>
                                <p>
                                <span>250</span> грн.
                                        <a href="#" class="pull-right">Детальніше
                                                <img src="img/arrow.svg" alt='->'>
                                        </a>
                                </p>
                        </div>
                </aside>
                <aside>
                        <div class="main-photo">
                                <img src="img/other3.jpg" alt="">
                        </div>
                        <div class="content">
                                <h3>Водні екскурсії</h3>
                                <div class="grey"></div>
                                <p>
                                <span>100</span> грн.
                                        <a href="#" class="pull-right">Детальніше
                                                <img src="img/arrow.svg" alt='->'>
                                        </a>
                                </p>
                        </div>
                </aside>
                <aside>
                        <div class="main-photo">
                                <img src="img/other4.jpg" alt="">
                        </div>
                        <div class="content">
                                <h3>Автобусні перевезення</h3>
                                <div class="grey"></div>
                                <p>
                                <span>150</span> грн.
                                        <a href="#" class="pull-right">Детальніше
                                                <img src="img/arrow.svg" alt='->'>
                                        </a>
                                </p>
                        </div>
                </aside>
        </section>
        <ul class="pagg other">
                <li><a href="#"><</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">></a></li>
        </ul>
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
                                <a href="{{$visit['link']}}" class="pull-right">Детальніше
                                        <img src="img/arrow.svg" alt='->'>
                                </a>
                        </p>
                </div>
        </aside>
        @endforeach
</section>
<script>
var map_hotel;
var ma;
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
@endsection

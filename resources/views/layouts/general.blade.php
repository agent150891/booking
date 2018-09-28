<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Світязь. Дошка оголошень зі сдачі житла.</title>
	<link href="{{ asset('/css/app.css')}}" rel="stylesheet">
        <link href="{{ asset('/css/style.css')}}" rel="stylesheet">
        <link href="{{ asset('/css/jquery.fancybox.min.css')}}" rel="stylesheet">
        <script src="https://use.fontawesome.com/5ec193cf54.js"></script>
        <script src="{{asset('js/mask.js')}}"></script>
        <script src="{{asset('js/app.js')}}"></script>
        <script src="{{asset('js/functions.js')}}"></script>
</head>
<body>
    @php
    function tel($phone){
        $p ='+';
        $p .= substr($phone, 0, 2);
        $p .= ' (';
        $p .=substr($phone, 2, 3);
        $p .= ') ';
        $p .=substr($phone, 5, 3);
        $p .= '-';
        $p .=substr($phone, 8, 2);
        $p .= '-';
        $p .=substr($phone, 10, 2);
        return $p;
    }
    @endphp
    <!-- Modal login-->
        <div id="modal_login" class="modal fade add-hotel" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
    	    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Авторізація</h4>
                    </div>
                    <div class="modal-body">
                        <h4 >Введіть, будь ласка, Ваш номер телефону та пароль</h4>
                        @if ($cuser)
                            <input type="text" placeholder="+38 (000) 000 00 00" id="login_phone" value="{{tel($cuser->phone)}}">
                        @else
                            <input type="text" placeholder="+38 (000) 000 00 00" id="login_phone">
                        @endif
                        <input type="password" placeholder="Пароль" id="login_pass">
                        <h5 class="small"><strong> Який Ви отримали при рєєстрації.</strong></h5>
    	      </div>
    	      <div class="modal-footer">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#repass"  data-dismiss="modal" id="recover">
  	        	       Забули пароль?&nbsp;&nbsp;&nbsp;
       		        <i class="fa fa-angle-right" aria-hidden="true"></i>
  	             </button>
    	        <button id="login1" type="button" class="btn btn-default pull-right" data-dismiss="modal" href="{{asset('\cabinet')}}">
    		        Увійти&nbsp;&nbsp;&nbsp;
    		        <i class="fa fa-angle-right" aria-hidden="true"></i>
    	        </button>
                <input type="hidden" value="{{asset('cabinet')}}" id="login_link">
    	      </div>
    	    </div>

    	  </div>
    	</div>
    <!-- END MODAL login-->
    <!-- Modal password recowery-->
        <div id="repass" class="modal fade add-hotel" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
    	    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Відновлення пароля</h4>
                    </div>
                    <div class="modal-body">
                        <h4 >Введіть, будь ласка,пароль, який ви отримали</h4>
                        <div class="user-info">
                            <strong>Ваше ім'я: </strong><span id="re_name">Петро Забава</span>

                        </div>
                        <div class="user-info">
                            <strong>Ваш номер: </strong><span id="re_phone">+38(097) 854 87 87</span>
                        </div>
                        <input type="password" placeholder="Пароль" id="re_pass">
    	      </div>
    	      <div class="modal-footer">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal_login"  data-dismiss="modal">
  	        	        <i class="fa fa-angle-left" aria-hidden="true"></i>
  	        	            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Повернутися
  	             </button>
    	        <button id="login2" type="button" class="btn btn-default pull-right" data-dismiss="modal">
    		        Увійти&nbsp;&nbsp;&nbsp;
    		        <i class="fa fa-angle-right" aria-hidden="true"></i>
    	        </button>
    	      </div>
    	    </div>

    	  </div>
    	</div>
    <!-- END MODAL password recowery-->
<!-- Modal 1-->
    <div id="add_hotel_1" class="modal fade add-hotel" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
	    <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Розмістити оголошення</h4>
                </div>
                <div class="modal-body">
                    <h4 >Введіть, будь ласка, Ваше ім'я і номер телефону</h4>
                    <ul class="steps">
                        <li class="active">1</li>
                        <li>2</li>
                        <li>3</li>
                        <li>4</li>
                        <li>5</li>
                        <li>6</li>
                  </ul>
                  @if ($cuser)
                      <input type="text" placeholder="Ваше ім'я" id="add_user_name" value="{{$cuser->name}}">
                      <input type="text" placeholder="+38 (000) 000 00 00" id="add_user_phone" value="{{tel($cuser->phone)}}">
                  @else
                      <input type="text" placeholder="Ваше ім'я" id="add_user_name">
                      <input type="text" placeholder="+38 (000) 000 00 00" id="add_user_phone">
                  @endif

                  <h5 class="small">Вам надійде СМС з кодом для продовження рєєстрації</h5>
	      </div>
	      <div class="modal-footer">
	        <button id="next1" type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#add_hotel_2"  data-dismiss="modal">
		        Продовжити&nbsp;&nbsp;&nbsp;
		        <i class="fa fa-angle-right" aria-hidden="true"></i>
	        </button>
	      </div>
	    </div>

	  </div>
	</div>
<!-- END MODAL 1-->

<!-- Modal 2-->
    <div id="add_hotel_2" class="modal fade add-hotel" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
	    <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Розмістити оголошення</h4>
                </div>
                <div class="modal-body">
                    <h4 >Введіть, будь ласка, пароль, який Ви отримали</h4>
                    <ul class="steps">
                        <li>1</li>
                        <li class="active">2</li>
                        <li>3</li>
                        <li>4</li>
                        <li>5</li>
                        <li>6</li>
                  </ul>
                    <div class="user-info">
                        <strong>Ваше ім'я: </strong><span id="user_name">Петро Забава</span>
                    </div>
                    <div class="user-info">
                        <strong>Ваш номер: </strong><span id="user_phone">+38(097) 854 87 87</span>
                    </div>
                    <input type="text" placeholder="пароль з СМС" id='add_user_pass'>
	      </div>
	      <div class="modal-footer">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#add_hotel_1"  data-dismiss="modal">
	        	<i class="fa fa-angle-left" aria-hidden="true"></i>
	        	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Повернутися
	        </button>
	        <button id="next2" type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#add_hotel_3" data-dismiss="modal" >
		        Продовжити&nbsp;&nbsp;&nbsp;
		        <i class="fa fa-angle-right" aria-hidden="true"></i>
	        </button>
	      </div>
	    </div>

	  </div>
	</div>
<!-- END MODAL 2-->
<!-- Modal 3-->
    <div id="add_hotel_3" class="modal fade add-hotel" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
	    <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Розмістити оголошення</h4>
                </div>
                <div class="modal-body">
                    <h4>Інформація місце відпочинку</h4>
                    <ul class="steps">
                        <li>1</li>
                        <li>2</li>
                        <li class="active">3</li>
                        <li>4</li>
                        <li>5</li>
                        <li>6</li>
                    </ul>
                    <div class="select-box">
                        <input type="text" placeholder="Введіть назву" class="left" id="add_hotel_name">
                        <select class="right" id="add_hotel_type">
                            <option value="0">Оберить тип житла</option>
                            @foreach($htypes as $htype)
                                <option value="{{$htype['id']}}">{{$htype['hotel_type']}}</option>
                            @endforeach
                        </select>
                        <select class="left" id="add_hotel_rooms">
                            <option value="0" selected>Кількість номерів</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                        <select class="right" id="add_hotel_lux">
                            <option value="0" selected>Кількість номерів класу люкс</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                    <h4>На теріторії бази:</h4>
                    <label class="check">
                                <input type="checkbox" id="hotel_parking"><span></span>
                                Стоянка
                    </label>
                        <label class="check">
                                <input type="checkbox" id="hotel_altan"><span></span>
                                Альтанки
                        </label>
                        <label class="check">
                                <input type="checkbox" id="hotel_kids"><span></span>
                                Дитячий майданчик
                        </label>
                        <label class="check">
                                <input type="checkbox" id="hotel_kitchen"><span></span>
                                Кухня
                        </label>
                    <div class="radio-box">
                        Душ/туалет:&nbsp;&nbsp;&nbsp;
                        <label>
                                <input type="radio" name="wc_type" checked id="wc_type">
                                <div class="check"></div> В номері
                        </label>
                        <label>
                                <input type="radio" name="wc_type">
                                <div class="check"></div> Загальний
                        </label>
                    </div>
                    <textarea id="add_hotel_about">Короткий опис вашої бази відпочинку</textarea>
                    <div><small>до 1000 символов</small></div>
                    <div class="mixed1">
                        Вартість від:
                        <input type="text" class="small" id="add_hotel_cost">
                        <label>
                                <input type="radio" name="pay_type" checked id="price_type">
                                <div class="check"></div> За номер
                        </label>
                        <label>
                                <input type="radio" name="pay_type">
                                <div class="check"></div> За ліжкомісце
                        </label>
                    </div>
                    <button type="button" class="btn btn-default" id="add_hotel_photo">
                            Завантажити фото&nbsp;&nbsp;
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                  </button>
                  <input type="file" name="load_photo" accept="image/*" id="load_photo" class="hidden">
                  <div>
                      <small>На фото має бути загальний вигляд вашого обїекту (будинок, подвір'я, але не фото кімнат, мінімум 1 фото)</small>
                  </div>
                    <ul class='photos' id="hotel-photos">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
	      </div>
	      <div class="modal-footer">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#add_hotel_2" data-dismiss="modal">
	        	<i class="fa fa-angle-left" aria-hidden="true"></i>
	        	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Повернутися
	        </button>
	        <button id="next3" type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#add_hotel_4"  data-dismiss="modal">
		        Продовжити&nbsp;&nbsp;&nbsp;
		        <i class="fa fa-angle-right" aria-hidden="true"></i>
	        </button>
	      </div>
	    </div>

	  </div>
	</div>
<!-- END MODAL 3-->
<!-- Modal 4-->
    <div id="add_hotel_4" class="modal fade add-hotel" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
	    <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Розмістити оголошення</h4>
                </div>
                <div class="modal-body">
                    <h4>Інформація місце відпочинку</h4>
                    <ul class="steps">
                        <li>1</li>
                        <li>2</li>
                        <li>3</li>
                        <li class="active">4</li>
                        <li>5</li>
                        <li>6</li>
                    </ul>
                    <div class="select-box">
                        <select class="left" id="add_city">
                            <option value="0">Виберіть населений пункт</option>
                            @foreach($cities as $city)
                                <option value="{{$city['id']}}">{{$city['city']}}</option>
                            @endforeach
                        </select>
                        <input type="text" placeholder="Введіть адресу" class="right" id="add_address">
                    </div>
                    <div>
                        <small>Розмістить Вашу базу на середині карти</small>
                    </div>
                    <div id="add_map">
                    </div>
                    <div class="mixed2">
                        <label><span>До пляжу</span> <input type="text" placeholder="0" id="add_beach"> м</label>
                        <button type="button" class="btn btn-default">Зберегти</button>
                        <button type="button" class="btn btn-default">Редагувати</button>
                    </div>
                    <div class="mixed3">
                        <label><span>До магазину</span> <input type="text" placeholder="0" id="add_shop"> м</label>
                        <label><span class="right">До ресторану</span> <input type="text" placeholder="0" id="add_rest"> м</label>
                        <label><span>До дискотеки</span> <input type="text" placeholder="0" id="add_disco"> м</label>
                        <label><span class="right">До зупинки</span> <input type="text" placeholder="0" id="add_bus"> м</label>
                    </div>
	      </div>
	      <div class="modal-footer">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#add_hotel_3" data-dismiss="modal">
	        	<i class="fa fa-angle-left" aria-hidden="true"></i>
	        	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Повернутися
	        </button>
	        <button id="next4" type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#add_hotel_5"  data-dismiss="modal">
		        Продовжити&nbsp;&nbsp;&nbsp;
		        <i class="fa fa-angle-right" aria-hidden="true"></i>
	        </button>
	      </div>
	    </div>

	  </div>
	</div>
<!-- END MODAL 4-->
<!-- Modal 5-->
    <div id="add_hotel_5" class="modal fade add-hotel" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
	    <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Розмістити оголошення</h4>
                </div>
                <div class="modal-body">
                    <h4>Інформація місце відпочинку</h4>
                    <ul class="steps">
                        <li>1</li>
                        <li>2</li>
                        <li>3</li>
                        <li>4</li>
                        <li class="active">5</li>
                        <li>6</li>
                    </ul>
                    <div class="big-input">
                        <input type="text" placeholder="Введіть назву або порядковий номер кімнати" id="room_name">
                    </div>
                    <div class="select-box">
                        <select class="left" id="room_beds">
                            <option value="0">Кількість спальних місць</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <input type="text" placeholder="Вартість номера за добу грн" class="right" id="room_cost">
                    </div>
                    <h4>В номері є:</h4>
                    <div class="room-check">
                        <label>
                            <input type="checkbox" id="room_wc"><span></span>
                            Туалет
                        </label>
                        <label>
                            <input type="checkbox" id="room_bath"><span></span>
                            Душ
                        </label>
                        <label>
                            <input type="checkbox" id="room_cond"><span></span>
                            Кондиціонер
                        </label>
                        <label>
                            <input type="checkbox" id="room_tv"><span></span>
                            Телевізор
                        </label>
                        <label>
                            <input type="checkbox" id="room_holo"><span></span>
                            Холодильник
                        </label>
                        <label>
                            <input type="checkbox" id="room_kitchen"><span></span>
                            Кухня
                        </label>
                        <label>
                            <input type="checkbox" id="room_wifi"><span></span>
                            WI-FI
                        </label>
                    </div>
                    <div class="add_room_photo">
                        <button type="button" class="btn btn-default" id="add_room_photo">
                            Завантажити фото&nbsp;&nbsp;
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                        </button>
                        <input type="file" accept="image/*" id="load_rphoto" class="hidden">
                    </div>
                    <div><small>На фото має бути вигляд номера і зручностей в ньому (мінімум 3 фото, можна більше).</small></div>
                    <ul class='photos' id="room-photos">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                    <textarea id="add_room_about">Короткий опис номера</textarea>
                    <div><small>До 1000 символів</small></div>
                    <div class="add_another_room">
                        <button type="button" class="btn btn-default pull-right" id="add_other_room">
                            + Ще один номер&nbsp;&nbsp;&nbsp;
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                        </button>
                    </div>
	      </div>
	      <div class="modal-footer">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#add_hotel_4" data-dismiss="modal">
	        	<i class="fa fa-angle-left" aria-hidden="true"></i>
	        	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Повернутися
	        </button>
	        <button id="next5" type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#add_hotel_6"  data-dismiss="modal">
		        Опублікувати&nbsp;&nbsp;&nbsp;
		        <i class="fa fa-angle-right" aria-hidden="true"></i>
	        </button>
	      </div>
	    </div>

	  </div>
	</div>
<!-- END MODAL 5-->
<!-- Modal 6-->
    <div id="add_hotel_6" class="modal fade add-hotel" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
	    <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Вітаємо!</h4>
                </div>
                <div class="modal-body">
                    <h4 class="step6">Ваше оголошення успішно подано</h4>
                    <ul class="steps">
                        <li>1</li>
                        <li>2</li>
                        <li>3</li>
                        <li>4</li>
                        <li>5</li>
                        <li class="active">6</li>
                  </ul>
                    <div class="user-info">
                        <strong>Тип оголошення: </strong><span>безкоштовне</span>
                    </div>
                    <div class="user-info">
                        <strong>Дійсне до: </strong><span id="date_out"></span>
                    </div>
                    <div class="text">Якщо Ви бажаєте продовжити термін розміщення оголошення,
                        виділити, підняти Ваше оголошення,
                        редагувати або або переглянути, то перейдіть в Ваш особистий кабінет
                    </div>
	      </div>
	      <div class="modal-footer step6">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#add_hotel_3"  data-dismiss="modal">
	        	Подати ще одне оголошення
	        </button>
	        <a id="next6" href="{{asset('cabinet')}}" class="btn btn-default pull-right">
		        Перейти в особистий кабінет
	        </a>
	      </div>
	    </div>

	  </div>
	</div>
<!-- END MODAL 6-->
	<header>
		<div>
		<a href="{{asset('/')}}">
			<img src="{{asset('img/logo.png')}}">
		</a>
		<nav>
            @if(session('user_id'))
                <button class="btn btn-warning btn-sm link"><a href="{{asset('cabinet')}}">Мій профіль</a></button>
                <button  class="btn btn-info btn-sm" data-toggle="modal" data-target="#add_hotel_3">Подати оголошення</button>
            @else
                <button class="btn btn-warning btn-sm"  data-toggle="modal" data-target="#modal_login">Мій профіль</button>
                <button  class="btn btn-info btn-sm" data-toggle="modal" data-target="#add_hotel_1">Подати оголошення</button>
            @endif
		</nav>
		<div class="input-group">
				<input type="text" placeholder="Введіть текст" name="seach" class="form-control input-sm col-xs-6" id="text_search">
				<div class="input-group-btn">
					<input type="submit" name="" class="btn btn-success btn-sm" value="Шукати "  id="filter_but0">
				</div>
		</div>
		<div class="lang">
			<button class="btn btn-xs btn-success">UA</button>
			<button class="btn btn-xs">EN</button>
			<button class="btn btn-xs">RU</button>
		</div>
		</div>
	</header>

        @yield('content')

	<footer>
		<div>
			<aside>
				<div>
                <a href="{{asset('/')}}">
				    <img src="{{asset('img/logo2.png')}}" alt="logo">
                </a>
				<p>Ми працюємо щодня з 8.00 до 20.00. Телефонуйте або пишіть - Ми дамо детальний і кваліфіковану відповідь на ваше запитання.</p>
				</div>
				<ul>
					<li><a href="">ЗВОРОТНІЙ ЗВ'ЯЗОК</a></li>
					<li><a href="">НОВИНИ</a></li>
					<li><a href="">ЯК ЗАБРОНЮВАТИ</a></li>
					<li><a href="">ПРАВИЛА ВИКОРИСТАННЯ</a></li>
					<li><a href="">ЯК ПОДАТИ ОГОЛОШЕННЯ</a></li>
				</ul>
			</aside>
			<aside class="social pull-right">
				<button class="btn btn-warning btn-sm">Мій профіль</button>
				<button class="btn btn-info">Подати оголошення</button>
				<div>
					<a href="https://vk.com"><b>B</b></a>
					<a href="https://plus.google.com" class="g">g<small>+</small></a>
					<a href="https://twitter.com"><i class="fa fa-twitter" aria-hidden="true"></i></a>
					<a href="https://ok.ru"><i class="fa fa-odnoklassniki" aria-hidden="true"></i></a>
					<a href="https://www.facebook.com"><i class="fa fa-facebook" aria-hidden="true"></i></a>
					<a href="#"><i class="fa fa-rss" aria-hidden="true"></i></a>
				</div>
				<small>Copyright &copy; 2017. All right reserved</small>
			</aside>
		</div>
	</footer>
<script src="{{asset('js/jquery.mask.min.js')}}"></script>
<script src="{{asset('js/verify2.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDRpv4YvVWl3H7xRzdkqzRXNLdCCNHfXv8&language=uk&region=UA&callback=initMap">
</script>
</section>
<script src="{{asset('js/jquery.fancybox.min.js')}}"></script>
</body>
</html>

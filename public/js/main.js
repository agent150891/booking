(function($){$(function(){
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
mask('add_user_phone');
mask('login_phone');
mask4('add_beach');
mask4('add_shop');
mask4('add_disco');
mask4('add_rest');
mask4('add_bus');
var phone = '';
var hotel = {};
var user = {};

/*
var rrr = {
    'user':{'name':'Vov1'},
};
$.ajax({
      url: baseUrl+'test',
      type:'post',
      data: rrr,
      success: function(data){
        console.log(data);
      }
  });*/

$('#next1').click(function(){//нажата кнопка Продолжить в первом модальном окне
    if (verify([['add_user_name','name'],['add_user_phone','tel']])==false){
        return false;
    } else{ //данные введены в форму корректно
        $('#user_name').text($('#add_user_name').val());
        $('#user_phone').text($('#add_user_phone').val());
        phone = $('#add_user_phone').val();
        phone = phone.replace(/\+/,'');
        phone = phone.replace(/\(/,'');
        phone = phone.replace(/\)/,'');
        phone = phone.replace(/[ ]{1}/,'');
        phone = phone.replace(/[-]{1}/,'');
        phone = phone.replace(/[ ]{1}/,'');
        phone = phone.replace(/[-]{1}/,'');
        user.phone = phone;
        user.name = $('#add_user_name').val();
        $.ajax({
              url: baseUrl+'sms/smssendcode',
              type:'post',
              data:'phone='+phone+'&about=перевірка телефону',
              success: function(data){
              	getSms();
              }
	      });
    }
});

$('#next2').addClass('disabled');

var next3 = false;

$('#add_user_pass').keyup(function(){
  $.ajax({
        url: baseUrl+'main/checkcode',
        type:'post',
        data:'phone='+phone+'&code='+$('#add_user_pass').val(),
        success: function(data){
          if (data){
            $('#next2').removeClass('disabled');
            next3 = true;
          }
          else{
              $('#next2').addClass('disabled');
              next3 = false;
          }
        }
  });
});

$('#next2').click(function(){//нажата кнопка Продолжить во втором модальном окне
      return next3;
});

function getSms(){//функция получения СМС
  $.ajax({
        url: baseUrl+'sms/smsget',
        type:'post',
        success: function(data){
          data = JSON.parse(data);
          var mess = 'SMS:'+data['message']+' phone:'+data['phone'];
          alert(mess);
        }
  });
}

$('#add_hotel_about').focus(function(){
    if ($('#add_hotel_about').val().trim()=="Короткий опис вашої бази відпочинку"){
        $('#add_hotel_about').val('');
    };
});
$('#add_hotel_about').blur(function(){
    if ($('#add_hotel_about').val().trim()==""){
        $('#add_hotel_about').val("Короткий опис вашої бази відпочинку");
    };
});

//загрузка фото отеля
var hPhotoNum=0;
var hotelPhotos = [];

$('#add_hotel_photo').click(function(){//нажата кнопка добавить фото
	if (hPhotoNum<5) {
        $('#load_photo').trigger('click');
    }
	return false;
});

$('#load_photo').on('change',function(){//получена картинка
    $('#hotel-photos li:nth-child('+(hPhotoNum+1)+')').html('<img src="/public/img/wait.gif" alt="waiting">');
	var files = this.files;
	var data = new FormData();
    $.each( files, function( key, value ){
        data.append( key, value );
    });
    $.ajax({
		url: baseUrl+'main/addphoto',
		type: 'POST',
		data:data,
        processData: false,
        contentType: false,
		success: function(rdata){
            hotelPhotos[hPhotoNum] = rdata;
            hPhotoNum++;
			var img='<img src="/storage/app/'+rdata+'" alt="hotel-photo">';
			$('#hotel-photos li:nth-child('+hPhotoNum+')').html(img);
		}
	});
});
//конец загрузки фото отеля


function get_radio(id){
    if ($("#"+id).prop('checked')){
        return 0;
    } else {
        return 1;
    }
}

$('#next3').click(function(){//нажата кнопка Продолжить в третьем модальном окне
var ver=verify([['add_hotel_name','name'],['add_hotel_type','num'],['add_hotel_rooms','num'],['add_hotel_about','text'],['add_hotel_cost','num']]);
      if (!ver || hPhotoNum<1){
          return false;
      } else{
          phone = $('#add_user_phone').val();
          phone = phone.replace(/\+/,'');
          phone = phone.replace(/\(/,'');
          phone = phone.replace(/\)/,'');
          phone = phone.replace(/[ ]{1}/,'');
          phone = phone.replace(/[-]{1}/,'');
          phone = phone.replace(/[ ]{1}/,'');
          phone = phone.replace(/[-]{1}/,'');
          user.phone = phone;
          user.name = $('#add_user_name').val();
          hotel.photos = hotelPhotos;
          hotel.title = $('#add_hotel_name').val().trim();
          hotel.hotel_type_id = $('#add_hotel_type').val();
          hotel.rooms = $('#add_hotel_rooms').val();
          hotel.lux = $('#add_hotel_lux').val();
          hotel.about = $('#add_hotel_about').val().trim();
          hotel.price = $('#add_hotel_cost').val();
          hotel.price_type = get_radio('price_type');
          hotel.bath = get_radio('wc_type');
          hotel.parking = get_check('hotel_parking');
          hotel.altan = get_check('hotel_altan');
          hotel.kids = get_check('hotel_kids');
          hotel.kitchen = get_check('hotel_kitchen');
      }
});

//MAP
var beachPoints;
$("#add_hotel_4").on("shown.bs.modal", function () {
    google.maps.event.trigger(map, "resize");//для отображеия карты
    $.ajax({//загружаем точки пляжа
        url: baseUrl+'main/getbeach',
        type:'post',
        success: function(data){
            beachPoints = JSON.parse(data);
        }
    });
});

var marker = false;

$('#add_city').change(function(){
    $.ajax({
          url: baseUrl+'main/selectcitymap',
          type:'post',
          data: 'city='+$('#add_city').val(),
          success: function(data){
            data = JSON.parse(data);
            map.setCenter(data);
            hotel.city_id = $('#add_city').val();
            hotel.gps_alt = data.lat;
            hotel.gps_lng = data.lng;
            if (marker){
                marker.setMap(null)
            };
            marker = new google.maps.Marker({
                position: data,
                map: map,
                draggable:true,
                title:"сдаю тут"
            });
            var lat = hotel.gps_alt;
            var lng = hotel.gps_lng;
            var b1 = beachPoints[0];
            var x=(lat-b1.lng)*70000;
            var y=(lng-b1.alt)*111000;
            var min=Math.sqrt(x*x+y*y);
            for (i=0; i<beachPoints.length; i++) {
                x=(lat-beachPoints[i].lng)*70000;
                y=(lng-beachPoints[i].alt)*111000;
                var len=Math.sqrt(x*x+y*y);
                if (len<min) min=len;
                //min - минимальное расстояние в метрах
            }
            $('#add_beach').val(Math.round(min));
            hotel.gps_alt = lng;
            hotel.gps_lng = lat;
            marker.addListener('drag', function(e) {
            	var location = marker.getPosition();
            	lat =location.lat();
            	lng = location.lng();
                b1 = beachPoints[0];
                x=(lat-b1.lng)*70000;
                y=(lng-b1.alt)*111000;
                min=Math.sqrt(x*x+y*y);
                for (i=0; i<beachPoints.length; i++) {
                    x=(lat-beachPoints[i].lng)*70000;
                    y=(lng-beachPoints[i].alt)*111000;
                    len=Math.sqrt(x*x+y*y);
                    if (len<min) min=len;
                    //min - минимальное расстояние в метрах
                }
                $('#add_beach').val(Math.round(min));
                hotel.gps_alt = lng;
                hotel.gps_lng = lat;
            });
          }
    });
});

//end MAP

$('#next4').click(function(){//нажата кнопка Продолжить во четвертом модальном окне
var ver=verify([['add_city','num'],['add_address','text'],['add_beach','num'],['add_shop','num'],['add_rest','num'],['add_disco','num'],['add_bus','num']]);
      if (!ver){
          return false;
      } else {
          hotel.city_id = $('#add_city').val();
          if (marker){
              var location = marker.getPosition();
              lat =location.lat();
              lng = location.lng();
              hotel.gps_alt = lng;
              hotel.gps_lng = lat;
          }
          hotel.address = $('#add_address').val();
          hotel.to_beach = $('#add_beach').val();
          hotel.to_shop = $('#add_shop').val();
          hotel.to_disco = $('#add_disco').val();
          hotel.to_rest = $('#add_rest').val();
          hotel.to_bus = $('#add_bus').val();
      }
});

//modal 5
$('#add_room_about').focus(function(){
    if ($('#add_room_about').val().trim()=="Короткий опис номера"){
        $('#add_room_about').val('');
    };
});
$('#add_room_about').blur(function(){
    if ($('#add_room_about').val().trim()==""){
        $('#add_room_about').val("Короткий опис номера");
    };
});

//загрузка фото номера
var rPhotoNum=0;
var roomPhotos = [];
var rooms =[];
var roomNum=0;

$('#add_room_photo').click(function(){//нажата кнопка добавить фото
	if (rPhotoNum<5) {
        $('#load_rphoto').trigger('click');
    }
	return false;
});

$('#load_rphoto').on('change',function(){//получена картинка
    $('#room-photos li:nth-child('+(rPhotoNum+1)+')').html('<img src="/public/img/wait.gif" alt="waiting">');
    var files = this.files;
	var data = new FormData();
    $.each( files, function( key, value ){
        data.append( key, value );
    });
    $.ajax({
		url: baseUrl+'main/addphoto',
		type: 'POST',
		data:data,
        processData: false,
        contentType: false,
		success: function(rdata){
            roomPhotos[rPhotoNum] = rdata;
            rPhotoNum++;
			var img='<img src="/storage/app/'+rdata+'" alt="room-photo">';
			$('#room-photos li:nth-child('+rPhotoNum+')').html(img);
		}
	});
});
//конец загрузки фото отеля

function get_check(id){//проверка ckeckbox элементов
    var c = $('#'+id);
    if (c.prop('checked')){
        return 1;
    } else {
        return 0;
    }
}

function add_room(){//добавляем комнату в массив комнат
    rooms[roomNum]={};
    rooms[roomNum].title = $('#room_name').val().trim();
    rooms[roomNum].beds = $('#room_beds').val();
    rooms[roomNum].price = $('#room_cost').val();
    rooms[roomNum].price_type = 0;
    rooms[roomNum].about = $('#add_room_about').val().trim();
    rooms[roomNum].wc = get_check('room_wc');
    rooms[roomNum].bath = get_check('room_bath');
    rooms[roomNum].tv = get_check('room_tv');
    rooms[roomNum].cond = get_check('room_cond');
    rooms[roomNum].holo = get_check('room_holo');
    rooms[roomNum].kitchen = get_check('room_kitchen');
    rooms[roomNum].wifi = get_check('room_wifi');
    rooms[roomNum].photos=roomPhotos;
    roomNum++;
    //обнуление формы комнаты
    $('#room_name').val('');
    $('#room_beds').val('');
    $('#room_cost').val('');
    $('#add_room_about').val('Короткий опис номера');
    $('#room_wc').prop("checked", false);
    $('#room_bath').prop("checked", false);
    $('#room_tv').prop("checked", false);
    $('#room_cond').prop("checked", false);
    $('#room_holo').prop("checked", false);
    $('#room_kitchen').prop("checked", false);
    $('#room_wifi').prop("checked", false);
    $('#room-photos').html('<li></li><li></li><li></li><li></li><li></li>');
    rPhotoNum=0;
    roomPhotos = [];
}

$('#add_other_room').click(function(){//кнопка добавить новую комнату
    var ver = verify([['room_name','name'],['room_beds','num'],['room_cost','num'],['add_room_about','text']]);
    if (!ver || rPhotoNum<3){
        return false;
    } else{
        add_room();
    }
});


function save_all(){
    var data = {};
    data.hotel = hotel;
    data.rooms = rooms;
    data.user = user;
    hotel = {};
    user = {};
    rooms = [];
    roomPhotos = [];
    rPhotoNum=0;
    hPhotoNum=0;
    roomNum=0;
    hotelPhotos = [];
    $('#hotel-photos').html('<li></li><li></li><li></li><li></li><li></li>');
    $('#room-photos').html('<li></li><li></li><li></li><li></li><li></li>');
    $.ajax({
        url: baseUrl+'main/publishhotel',
        type: 'POST',
        data: data,
        success: function(rdata){
            console.log(rdata);
            $('#date_out').text(rdata.substr(0,11));
        }
    });
}

$('#next5').click(function(){//нажата кнопка Продолжить в пятом модальном окне
    var ver = verify([['room_name','name'],['room_beds','num'],['room_cost','num'],['add_room_about','text']]);
    if (!ver || rPhotoNum<3){
        return false;
    } else{
        add_room();
        save_all();
    }
});

// PAGGINATION
var start_page=1;
var search =0;

function add_pagg(){
    $('#hotel_pagg li:first-child').click(function(){
        if (!$(this).hasClass('disabled')){
            var filter=get_filter();
            room_pagg(start_page-1,filter);
        }
        return false;
    });

    $('#hotel_pagg li:last-child').click(function(){
        if (!$(this).hasClass('disabled')){
            var filter=get_filter();
            room_pagg(start_page+1,filter);
        }
        return false;
    });

    $('#hotel_pagg li a').each(function(){
        if (parseInt($(this).text())>0){
            $(this).click(function(){
                var filter=get_filter();
                room_pagg(parseInt($(this).text()),filter);
                return false;
            });
        }
    });
}

////////////// FILTER
function get_filter(){
    var filter = {};
    filter.city_id = $('#city_id').val();
    filter.hotel_type_id = $('#hotel_type_id').val();
    filter.beds = $('#beds').val();
    filter.reight = get_check('reight');
    filter.bath = get_check('bath');
    filter.wc = get_check('wc');
    filter.cond = get_check('cond');
    filter.tv = get_check('tv');
    filter.wifi = get_check('wifi');
    filter.kitchen = get_check('kitchen');
    filter.sort = $('#sort').val();
    filter.text='';
    return filter;
}
/// END FILTER


add_pagg();

function room_pagg(page, filter=null){
    var send_data = {'page':page,'filter':filter};
    $.ajax({
          url: baseUrl+'hotel/paggination',
          type:'post',
          data: send_data,
          success: function(data){
            data = JSON.parse(data);
            var list = '';
            search = data.count;
            if (filter){
                $('#count_filter').text(search);
            }
            for(var i = 0; i < data.list.length; i++){
                list += '<aside><div class="photo"><a href="hotel/';
                list += data.list[i].id;
                list += '"><img src="/storage/app/';
                list += data.list[i].foto1;
                list += '" alt="hotel_photo"><img src="img/images.png" alt="images" class="images"></a>';
                var vip_date = new Date(data.list[i].date_vip);
                var top_date = new Date(data.list[i].date_top);
                var now_date = new Date;
                if (vip_date > now_date){
                    list += '<div class="vip"></div>';
                }
                if (top_date > now_date){
                    list += '<div class="top"></div>';
                }
                list += '</div><div class="content"><h3>';
                list += data.list[i].title;
                list += '</h3><div><ul><li><img src="img/beach.png" alt="beach"><div class="info-beach">Відстань до пляжу</div><span>';
                var b = parseInt(data.list[i].to_beach);
                if (b>=500){
                    list += (b/1000).toFixed(1);
                    list += '</span> км до пляжу';
                } else {
                    list += b;
                    list += '</span> м до пляжу';
                }
                list += '</li><li><img src="img/home.png" alt="home"><div class="info-rooms">всього номерів</div><span>';
                list += data.list[i].rooms;
                list += '';
                list += '</span> кімнат</li><li><img src="img/lux.png" alt="bath"><div class="info-lux">номерів Люкс</div><span>';
                list += data.list[i].lux;
                list += '</span> номерів Люкс</li></ul></div><div><img src="img/marker.png" alt="marker"><span>';
                list += data.list[i].address;
                list += '</span></div><div><img src="img/phone.png" alt="phone"><span class="phone">+';
                var p = data.list[i].phone;
                list += p.substr(0,2)+' ('+p.substr(2,3)+') '+p.substr(5,2)+'-'+p.substr(7,2)+'-'+p.substr(10,3);
                list += '</span></div><article>';
                list += data.list[i].about;
                list += '</article><div class="grey"></div><div class="details">від <span>';
                list += data.list[i].price;
                list += '</span> грн/доба<a href="hotel/';
                list += data.list[i].id;
                list += '" class="btn btn-success pull-right">Детальніше</a></div></div></aside>';
            }
            list += data.pagg;
            $('#hotel_list').html(list);
            start_page = page;
            add_pagg();
          }
      });
}


$('#filter_but').click(function(){
    var filter = get_filter();
    room_pagg(1, filter);
    start_page =1;
    return false;
});

$('#filter_but0').click(function(){
    var ver = verify([['text_search','name']]);
    if (ver){
        var filter = {'text':$('#text_search').val().trim()};
        room_pagg(1, filter);
        start_page =1;
    }
    return false;
});


////// photos
$('#hotel-photos li').each(function(){
    if ($(this).html() == ""){
        $(this).click(function(){
            $('#load_photo').trigger('click');
        });
    }
});

$('#room-photos li').each(function(){
    if ($(this).html() == ""){
        $(this).click(function(){
            $('#load_photo').trigger('click');
        });
    }
});
// end photos

//login

$('#login1').click(function(){
    ver = verify([['login_pass','pass']]);
    if (ver){
        var phone = $('#login_phone').val();
        phone = phone.replace(/\+/,'');
        phone = phone.replace(/\(/,'');
        phone = phone.replace(/\)/,'');
        phone = phone.replace(/[ ]{1}/,'');
        phone = phone.replace(/[-]{1}/,'');
        phone = phone.replace(/[ ]{1}/,'');
        phone = phone.replace(/[-]{1}/,'');
        var data = {'phone': phone,'password':$('#login_pass').val()};
        $.ajax({
            url: baseUrl+'main/login',
            type: 'POST',
            data: data,
            success: function(rdata){
                if (rdata){
                    document.location = $('#login_link').val();
                }
            }
        });
    }
    return false;
});

// end login
//recovery
    $('#recover').click(function(){
        $('#re_phone').text($('#login_phone').val());
        var phone = $('#login_phone').val();
        phone = phone.replace(/\+/,'');
        phone = phone.replace(/\(/,'');
        phone = phone.replace(/\)/,'');
        phone = phone.replace(/[ ]{1}/,'');
        phone = phone.replace(/[-]{1}/,'');
        phone = phone.replace(/[ ]{1}/,'');
        phone = phone.replace(/[-]{1}/,'');
        $.ajax({
            url: baseUrl+'main/setcode',
            type: 'POST',
            data: 'phone='+phone,
            success: function(rdata){
                if (rdata){
                    $('#re_name').text(rdata);
                    getSms();
                }
            }
        });
    });

    $('#login2').click(function(){
        ver = verify([['re_pass','pass']]);
        if (ver){
            var phone = $('#re_phone').text();
            phone = phone.replace(/\+/,'');
            phone = phone.replace(/\(/,'');
            phone = phone.replace(/\)/,'');
            phone = phone.replace(/[ ]{1}/,'');
            phone = phone.replace(/[-]{1}/,'');
            phone = phone.replace(/[ ]{1}/,'');
            phone = phone.replace(/[-]{1}/,'');
            var data = {'phone': phone,'password':$('#re_pass').val()};
            $.ajax({
                url: baseUrl+'main/login',
                type: 'POST',
                data: data,
                success: function(rdata){
                    if (rdata){
                        document.location = $('#login_link').val();
                    }
                }
            });
        }
        return false;
    });
//end recowery

})})(jQuery)

(function($){$(function(){
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

function get_radio(id){
      if ($("#"+id).prop('checked')){
          return 0;
      } else {
          return 1;
      }
}

mask4('e_rooms');
mask4('e_lux');
mask4('e_price');
mask4('beach');
mask4('shop');
mask4('rest');
mask4('disco');
mask4('bus');

function get_check(id){//проверка ckeckbox элементов
      var c = $('#'+id);
      if (c.prop('checked')){
          return 1;
      } else {
          return 0;
      }
}


//MAP
var beachPoints;
var marker = false;
var ehotel={};
var hotelPhotosNum=0;
ehotel.photos=[];
    $.ajax({//загружаем точки пляжа
        url: baseUrl+'main/getbeach',
        type:'post',
        success: function(data){
            beachPoints = JSON.parse(data);
            hotel_marker();
        }
    });

function hotel_marker(){
    $.ajax({
          url: baseUrl+'main/selectcitymap',
          type:'post',
          data: 'city='+$('#e_city').val(),
          success: function(data){
            data = JSON.parse(data);
            map_hotel.setCenter(data);
            ehotel.city_id = $('#e_city').val();
            ehotel.gps_alt = data.lat;
            ehotel.gps_lng = data.lng;
            if (marker){
                marker.setMap(null);
            };
            marker = new google.maps.Marker({
                position: data,
                map: map_hotel,
                draggable:true,
                title:"сдаю тут"
            });
            var lat = ehotel.gps_alt;
            var lng = ehotel.gps_lng;
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
            ehotel.gps_alt = lng;
            ehotel.gps_lng = lat;
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
                $('#beach').val(Math.round(min));
                ehotel.gps_alt = lng;
                ehotel.gps_lng = lat;
            });
          }
    });
}

$('#city').change(function(){
    hotel_marker();
});
//end MAP

//photos edit
$('#edit_photos li img').each(function(){//starting array with photos
    ehotel.photos[hotelPhotosNum] = $(this).prop('src').match(/(images.*)/)[0];
    hotelPhotosNum++;
});

$('#del_photo').click(function(){//нажата кнопка "Видалили фото"
    $('#edit_photos li i').each(function(){
        $(this).fadeToggle();
    });
    return false;
});



$.fn.addDelClick=function(){//функция добавления функции удаления
    $('#edit_photos li i').each(function(){
        $(this).hide();
    });
    $(this).click(function(){
        var del=0;
        for (i=0;i<ehotel.photos.length;i++){
        if (ehotel.photos[i] == $(this).prev().prop('src').match(/(images.*)/)[0]){
                del = i;
            }
        }
        ehotel.photos.splice(del,1);
        hotelPhotosNum--;
        $(this).parent().parent().append('<li></li>');
        $(this).parent().remove();
    });
};

$('#edit_photos li i').each(function(){
    $(this).addDelClick();
});

$('#add_photo').click(function(){//нажата кнопка добавить фото
	if (hotelPhotosNum<5) {
        $('#load_hotel_photo').trigger('click');
    }
	return false;
});

$('#load_hotel_photo').on('change',function(){//получена картинка
    $('#edit-photos li:nth-child('+(hotelPhotosNum+1)+')').html('<img src="/public/img/wait.gif" alt="waiting">');
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
            ehotel.photos[hotelPhotosNum] = rdata;
            hotelPhotosNum++;
			var img='<img src="/storage/app/'+rdata+'" alt="room-photo"><i class="fa fa-trash-o" aria-hidden="true"></i>';
			$('#edit_photos li:nth-child('+hotelPhotosNum+')').html(img);
            $('#edit_photos li:nth-child('+hotelPhotosNum+') i').addDelClick();
		}
	});
});
//end photos edit

$('#save_hotel_edit').click(function(){
    var ver = verify([['e_title','name'],['e_address','text'],['e_rooms','num'],['e_about','text'],['e_lux','num'],['e_price','num'],['beach','num'],['shop','num'],['rest','num'],['disco','num'],['bus','num']]);
    if (ver){
        ehotel.id = $('#hotel_id').val();
        ehotel.bath = get_radio('e_wc_type')
        ehotel.parking = get_check('e_parking');
        ehotel.wifi = get_check('e_wifi');
        ehotel.altan = get_check('e_altan');
        ehotel.kids = get_check('e_kids');
        ehotel.kitchen = get_check('e_kitchen');
        ehotel.hotel_type_id = $('#e_city').val();
        ehotel.title = $('#e_title').val().trim();
        ehotel.address = $('#e_address').val().trim();
        ehotel.rooms = $('#e_rooms').val().trim();
        ehotel.lux = $('#e_lux').val().trim();
        ehotel.about = $('#e_about').val().trim();
        ehotel.price = $('#e_price').val().trim();
        ehotel.price_type = get_radio('e_price_type');
        ehotel.to_beach = $('#beach').val().trim();
        ehotel.to_shop = $('#shop').val().trim();
        ehotel.to_disco = $('#disco').val().trim();
        ehotel.to_rest = $('#rest').val().trim();
        ehotel.to_bus = $('#bus').val().trim();
        for(i=ehotel.photos.length;i<5;i++){
            ehotel.photos[i]="";
        }
        var data = {};
        data.hotel = ehotel;
        $.ajax({
    		url: baseUrl+'hotel/'+ehotel.id,
    		type: 'PUT',
    		data: data,
            success: function(rdata){
                console.log(rdata);
    		}
    	});
    }
    return false;
});

})})(jQuery)

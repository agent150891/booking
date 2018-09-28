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

mask4('e_price');

function get_check(id){//проверка ckeckbox элементов
      var c = $('#'+id);
      if (c.prop('checked')){
          return 1;
      } else {
          return 0;
      }
}

var rooms = [];
$.ajax({
    url: baseUrl+'rooms/getlist',
    type: 'POST',
    data: 'hotel_id='+$('#hotel_id').val(),
    success: function(rdata){
        rooms = JSON.parse(rdata);
        get_book(today.getFullYear(), today.getMonth(), rooms[0].id);
    }
});

//календарь
var today = new Date();
var month=['январь','февраль','март','апрель','май','июнь','июль','август','сентября','октябрь','ноябрь','декабрь'];
var mdays=[31,28,31,30,31,30,31,31,30,31,30,31];
var week_day=['ПН','ВТ','СР','ЧТ','ПТ','СБ','ВС'];

if (today.getFullYear() % 4 == 0) mdays[1] = 29;
var table ='';
var count = mdays[today.getMonth()];
var now = new Date(today.getFullYear(), today.getMonth(), 1, 0, 0, 0, 0);
var first_days = (now.getDay() == 0) ? 6 : (now.getDay()-1);
now = new Date(today.getFullYear(), today.getMonth(), mdays[now.getMonth()], 0, 0, 0, 0);
var last_days = (now.getDay() == 0) ? 0 : ( 7- now.getDay());
var book=[];
function get_book(year, month, room_id){
    $.ajax({
          url: baseUrl+'getbook',
          type:'post',
          data:'year='+year+'&month='+month+'&room_id='+room_id,
          success: function(data){
              book = JSON.parse(data);
              if (first_days > 0) table ='<tr>';
              for (var i = 1; i <= first_days; i++) {
                  table+="<td></td>";
              }
              for (var i=1; i <= count; i++) {
                          now = new Date(today.getFullYear(),today.getMonth(), i, 0, 0, 0, 0)
                          if (now.getDay() == 1) table+='<tr>';
                          if (book[i]>0){
                              table += '<td class="book">';
                          } else{
                              table += '<td>';
                          }
                           table += i+'</td>';
                          if ( now.getDay == 0)  table+='</tr>';
                      }
                      for (var i=1; i <= last_days ; i++) {
                          table+="<td></td>";
                      }
                      table +='</tr>';
              $('#booking table tbody').html(table);
              add_click();
          }
    });
}

function add_click(){
    $('#booking table tbody tr td').each(function(){
    	$(this).click(function(){
    		var day = parseInt($(this).text());
    		if (day>0){
    			console.log('td=',day);
    			if ($(this).hasClass('book')){
    				$(this).removeClass('book');
    			} else{
    				$(this).addClass('book');
    			}
                var month='';
                if (today.getMonth()>9){
                    month = (today.getMonth()+1);
                } else{
                    month = '0'+(today.getMonth()+1);
                }
                var d='';
                if (today.getDate()>9){
                    d = day;
                } else{
                    d = '0'+day;
                }
                var setDay = today.getFullYear()+'-'+month+'-'+d;
                $.ajax({
                      url: baseUrl+'setbook',
                      type:'post',
                      data:'day='+setDay+'&room='+rooms[roomNum].id,
                      success: function(data){
                          console.log(data);
                      }
                });
    		}
    	})
    });
}

//календарь конец

//photos
var roomPhotoNum = 0;
var roomNum = 0;

function checkPhotos(){
    roomPhotoNum = 0
    $('.room-photos>div img').each(function(){
        roomPhotoNum++;
        if (roomPhotoNum==1) {
            rooms[roomNum].foto1 = $(this).prop('src').match(/(images.*)/)[0];
        }
        if (roomPhotoNum==2) {
            rooms[roomNum].foto2 = $(this).prop('src').match(/(images.*)/)[0];
        }
        if (roomPhotoNum==3) {
            rooms[roomNum].foto3 = $(this).prop('src').match(/(images.*)/)[0];
        }
        if (roomPhotoNum==4) {
            rooms[roomNum].foto4 = $(this).prop('src').match(/(images.*)/)[0];
        }
        if (roomPhotoNum==5) {
            rooms[roomNum].foto5 = $(this).prop('src').match(/(images.*)/)[0];
        }
        if (roomPhotoNum==6) {
            rooms[roomNum].foto6 = $(this).prop('src').match(/(images.*)/)[0];
        }
    });
    if (roomPhotoNum==0) {
        rooms[roomNum].foto1 = '';
        rooms[roomNum].foto2 = '';
        rooms[roomNum].foto3 = '';
        rooms[roomNum].foto4 = '';
        rooms[roomNum].foto5 = '';
        rooms[roomNum].foto6 = '';
    }
    if (roomPhotoNum==1) {
        rooms[roomNum].foto2 = '';
        rooms[roomNum].foto3 = '';
        rooms[roomNum].foto4 = '';
        rooms[roomNum].foto5 = '';
        rooms[roomNum].foto6 = '';
    }
    if (roomPhotoNum==2) {
        rooms[roomNum].foto3 = '';
        rooms[roomNum].foto4 = '';
        rooms[roomNum].foto5 = '';
        rooms[roomNum].foto6 = '';
    }
    if (roomPhotoNum==3) {
        rooms[roomNum].foto4 = '';
        rooms[roomNum].foto5 = '';
        rooms[roomNum].foto6 = '';
    }
    if (roomPhotoNum==4) {
        rooms[roomNum].foto5 = '';
        rooms[roomNum].foto6 = '';
    }
    if (roomPhotoNum==5) {
        rooms[roomNum].foto6 = '';
    }
}

$.fn.addDelClick=function(){//функция добавления функции удаления
    $('.room-photos div i').each(function(){
        $(this).hide();
    });
    $(this).click(function(){
        //$('.room-photos>div:last-of-type').after('<div></div>');
        $(this).parent().remove();
        checkPhotos();
    });
};

$('#del_photo').click(function(){//нажата кнопка "Видалили фото"
    $('.room-photos div i').each(function(){
        $(this).fadeToggle();
    });
    return false;
});

$('.room-photos div i').each(function(){
    $(this).addDelClick();
});

$('#add_rphoto').click(function(){//нажата кнопка добавить фото
	if (roomPhotoNum<6) {
        $('#load_room_photo').trigger('click');
    }
	return false;
});

$('#load_room_photo').on('change',function(){//получена картинка
    $('.room-photos>div:last-of-type').after('<div><img src="/public/img/wait.gif" alt="waiting"></div>');
    var files = this.files;
	var data = new FormData();
    $.each( files, function( key, value ){
        data.append( key, value );
    });
    if (this.files.length==0){
        $('.room-photos>div:last-of-type').remove();
    }
    $.ajax({
		url: baseUrl+'main/addphoto',
		type: 'POST',
		data:data,
        processData: false,
        contentType: false,
		success: function(rdata){
			var img='<img src="/storage/app/'+rdata+'" alt="room-photo"><i class="fa fa-trash-o" aria-hidden="true"></i>';
			$('.room-photos>div:last-of-type').html(img);
            $('.room-photos>div:last-of-type i').addDelClick();
            checkPhotos();
		}
	});
});
// end photos

$('.room-list ul li').each(function(){
    $(this).click(function(){
        if (save()){
            $('.room-list ul li').each(function(){
                $(this).removeClass('active');
            });
            $(this).addClass('active');
            roomNum=$(this).find('input').val();
            get_book(today.getFullYear(), today.getMonth(), rooms[roomNum].id);
            $('#e_title').val(rooms[roomNum].title);
            $('#e_about').val(rooms[roomNum].about);
            $('#e_price').val(rooms[roomNum].price);
            var sel = '';
            for(i=1;i<=8;i++){
                if (i==rooms[roomNum].beds){
                    sel += '<option value="'+i+'" selected="selected">'+i+'</option>';
                } else {
                    sel += '<option value="'+i+'">'+i+'</option>';
                }
            }
            $('#e_beds').html(sel);
            if (rooms[roomNum].price_type==0){
                $('#e_price_type').prop("checked","checked");
                $('#e_price_type1').removeProp("checked");
            } else {
                $('#e_price_type1').prop("checked","checked");
                $('#e_price_type').removeProp("checked");
            }
            if (rooms[roomNum].wc=='0'){
                $('#e_wc').prop("checked", false);
            } else {
                $('#e_wc').prop("checked",true);
            }
            if (rooms[roomNum].bath=='0'){
                $('#e_bath').prop("checked", false);
            } else {
                $('#e_bath').prop("checked",true);
            }
            if (rooms[roomNum].tv=='0'){
                $('#e_tv').prop("checked", false);
            } else {
                $('#e_tv').prop("checked",true);
            }
            if (rooms[roomNum].cond=='0'){
                $('#e_cond').prop("checked", false);
            } else {
                $('#e_cond').prop("checked",true);
            }
            if (rooms[roomNum].holo=='0'){
                $('#e_holo').prop("checked", false);
            } else {
                $('#e_holo').prop("checked",true);
            }
            if (rooms[roomNum].kitchen=='0'){
                $('#e_kitchen').prop("checked", false);
            } else {
                $('#e_kitchen').prop("checked",true);
            }
            $('.room-photos>div').remove();
            var pic = '';
            if (rooms[roomNum].foto1){
                pic += '<div><img src="/storage/app/'+rooms[roomNum].foto1+'" alt="room-photo"><i class="fa fa-trash-o" aria-hidden="true"></i></div>';
            }
            if (rooms[roomNum].foto2){
                pic += '<div><img src="/storage/app/'+rooms[roomNum].foto2+'" alt="room-photo"><i class="fa fa-trash-o" aria-hidden="true"></i></div>';
            }
            if (rooms[roomNum].foto3){
                pic += '<div><img src="/storage/app/'+rooms[roomNum].foto3+'" alt="room-photo"><i class="fa fa-trash-o" aria-hidden="true"></i></div>';
            }
            if (rooms[roomNum].foto4){
                pic += '<div><img src="/storage/app/'+rooms[roomNum].foto4+'" alt="room-photo"><i class="fa fa-trash-o" aria-hidden="true"></i></div>';
            }
            if (rooms[roomNum].foto5){
                pic += '<div><img src="/storage/app/'+rooms[roomNum].foto5+'" alt="room-photo"><i class="fa fa-trash-o" aria-hidden="true"></i></div>';
            }
            if (rooms[roomNum].foto6){
                pic += '<div><img src="/storage/app/'+rooms[roomNum].foto6+'" alt="room-photo"><i class="fa fa-trash-o" aria-hidden="true"></i></div>';
            }
            $('.room-photos menu').before(pic);
        }
    });
});

//save
function save(){
    var ver = verify([['e_title','name'],['e_price','num'],['e_about','text']]);
    if (ver){
        rooms[roomNum].title = $('#e_title').val().trim();
        rooms[roomNum].price = $('#e_price').val().trim();
        rooms[roomNum].price_type = get_radio('e_price_type');
        rooms[roomNum].beds = $('#e_beds').val();
        rooms[roomNum].wc = get_check('e_wc');
        rooms[roomNum].bath = get_check('e_bath');
        rooms[roomNum].tv = get_check('e_tv');
        rooms[roomNum].cond = get_check('e_cond');
        rooms[roomNum].holo = get_check('e_holo');
        rooms[roomNum].kitchen = get_check('e_kitchen');
        rooms[roomNum].about = $('#e_about').val().trim();
        $.ajax({
            url: baseUrl+'room/save',
            type: 'POST',
            data: rooms[roomNum],
            success: function(rdata){
            }
        });
    }
    return ver;
}

$('#save').click(function(){
    save();
    return false;
});
//end save

})})(jQuery)
